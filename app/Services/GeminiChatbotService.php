<?php

namespace App\Services;

use App\Models\GeminiConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Illuminate\Support\Facades\Log;

class GeminiChatbotService
{
    private string $apiKey;
    private string $model;
    private float $temperature;
    private int $maxOutputTokens;
    private string $systemPrompt;
    private string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        // Get active config from database (required)
        $config = GeminiConfig::getActive();
        
        if (!$config) {
            throw new Exception('Konfigurasi Gemini API belum diatur. Silakan atur di halaman Admin terlebih dahulu.');
        }
        
        $this->apiKey = $config->api_key;
        $this->model = $config->model;
        $this->temperature = $config->temperature;
        $this->maxOutputTokens = $config->max_output_tokens;
        $this->systemPrompt = $config->system_prompt;
        
        // Validate API key is not empty
        if (empty($this->apiKey)) {
            throw new Exception('API Key tidak diatur. Silakan periksa konfigurasi Gemini di halaman Admin.');
        }
    }

    /**
     * Get response dari Gemini API
     */
    public function getResponse(string $userMessage, array $conversationHistory = []): array
    {
        // Retry policy for transient server errors (503)
        $maxRetries = 3;
        $initialDelayMs = 500;

        try {
            // Siapkan messages untuk API
            $messages = $this->formatMessages($userMessage, $conversationHistory);

            // Call Gemini API menggunakan Guzzle client
            $client = new Client();
            $url = $this->apiUrl . '/models/' . $this->model . ':generateContent?key=' . $this->apiKey;

            $attempt = 0;
            $response = null;
            while ($attempt <= $maxRetries) {
                try {
                    $response = $client->post($url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => [
                            'contents' => $messages,
                            'generationConfig' => [
                                'temperature' => $this->temperature,
                                'topK' => 40,
                                'topP' => 0.95,
                                'maxOutputTokens' => $this->maxOutputTokens,
                            ],
                            'safetySettings' => [
                                [
                                    'category' => 'HARM_CATEGORY_HARASSMENT',
                                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                                ],
                            ],
                        ],
                        'timeout' => 30,
                    ]);

                    // if we reach here, request succeeded
                    break;
                } catch (RequestException $re) {
                    $attempt++;
                    $status = $re->getResponse() ? $re->getResponse()->getStatusCode() : null;
                    // Retry only on 5xx server errors (transient)
                    if ($status === 503 && $attempt <= $maxRetries) {
                        // exponential backoff with jitter
                        $delay = $initialDelayMs * (2 ** ($attempt - 1));
                        $jitter = rand(0, 200);
                        usleep(($delay + $jitter) * 1000);
                        continue;
                    }
                    // rethrow to be handled below
                    throw $re;
                }
            }

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new Exception('API request failed: ' . $statusCode . ' - ' . $response->getBody());
            }

            $data = json_decode($response->getBody(), true);

            // Assemble text from possible response shapes: candidates -> content -> parts
            $collected = [];

            if (isset($data['candidates']) && is_array($data['candidates'])) {
                foreach ($data['candidates'] as $cand) {
                    // Cek apakah respons diblokir oleh safety filter Gemini
                    $finishReason = $cand['finishReason'] ?? null;
                    if (in_array($finishReason, ['SAFETY', 'RECITATION', 'OTHER'])) {
                        throw new Exception('Respons diblokir oleh safety filter Gemini (finishReason: ' . $finishReason . '). Coba ubah pertanyaan Anda.');
                    }

                    if (isset($cand['content']['parts']) && is_array($cand['content']['parts'])) {
                        foreach ($cand['content']['parts'] as $part) {
                            if (isset($part['text'])) {
                                $collected[] = $part['text'];
                            }
                        }
                    }
                }
            }

            // Fallback shapes (older/newer responses)
            if (empty($collected) && isset($data['output']) && is_array($data['output'])) {
                foreach ($data['output'] as $out) {
                    if (isset($out['content']) && is_array($out['content'])) {
                        foreach ($out['content'] as $c) {
                            if (isset($c['text'])) $collected[] = $c['text'];
                        }
                    }
                }
            }

            if (empty($collected)) {
                // Sertakan pesan error dari API jika ada
                $apiError = $data['error']['message'] ?? ($data['candidates'][0]['finishReason'] ?? 'Format respons API tidak dikenali');
                throw new Exception('model output error: ' . $apiError . ', please try again');
            }

            $fullText = implode("\n\n", $collected);

            return [
                'success' => true,
                'message' => $fullText,
                'usage' => $data['usageMetadata'] ?? $data['usage'] ?? null,
            ];
        } catch (Exception $e) {
            // Redact API key from messages returned to client and logs
            $safeMsg = $this->redactSensitiveInfo($e->getMessage());

            try {
                Log::error('GeminiChatbotService error: ' . $safeMsg, ['exception' => $e]);
            } catch (\Throwable $logEx) {
                // ignore logging errors
            }

            return [
                'success' => false,
                'message' => 'Maaf, layanan pemrosesan sedang sibuk atau mengalami gangguan. Silakan coba beberapa saat lagi.',
                'error' => $safeMsg,
            ];
        }
    }

    /**
     * Redact API keys or sensitive query params from text
     */
    private function redactSensitiveInfo(string $text): string
    {
        // Redact &key=<value> or ?key=<value>
        $text = preg_replace('/([?&]key=)[^&\s]+/i', '$1[REDACTED]', $text);
        // Redact common API key patterns
        $text = preg_replace('/AIza[0-9A-Za-z_\-]{35}/', '[REDACTED_KEY]', $text);
        return $text;
    }

    /**
     * Format messages untuk Gemini API
     */
    private function formatMessages(string $userMessage, array $conversationHistory): array
    {
        $messages = [];

        // Tambahkan system prompt sebagai user message
        $messages[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $this->systemPrompt],
            ],
        ];

        // Tambahkan model response untuk system prompt
        $messages[] = [
            'role' => 'model',
            'parts' => [
                ['text' => 'Baik, saya siap membantu menjawab pertanyaan tentang administrasi RT.'],
            ],
        ];

        // Tambahkan conversation history
        foreach ($conversationHistory as $msg) {
            $messages[] = [
                'role' => strtolower($msg['role']) === 'user' ? 'user' : 'model',
                'parts' => [
                    ['text' => $msg['content']],
                ],
            ];
        }

        // Tambahkan user message saat ini
        $messages[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage],
            ],
        ];

        return $messages;
    }

    /**
     * Get default system prompt untuk RT administration
     */
    private function getDefaultSystemPrompt(): string
    {
        return $this->getDefaultPromptContent();
    }

    /**
     * Get default prompt content
     */
    private function getDefaultPromptContent(): string
    {
        return <<<'PROMPT'
Anda adalah chatbot asisten administrasi RT (Rukun Tetangga) yang helpful dan ramah.
Anda membantu warga dengan informasi tentang:
1. Persyaratan surat (surat keterangan, surat domisili, surat tidak mampu, surat pengalaman)
2. Prosedur administrasi RT
3. Jadwal pelayanan
4. Aturan dan kebijakan RT

Berikan jawaban yang:
- Jelas dan mudah dipahami
- Singkat dan padat
- Dalam bahasa Indonesia yang baik
- Helpful dan profesional

Jika ada pertanyaan yang tidak berhubungan dengan administrasi RT, kembalikan dengan halus dan tawarkan bantuan terkait RT.

Persyaratan Surat:
- Surat Keterangan: NIK, KTP, Surat Pengantar RT
- Surat Domisili: NIK, KTP, Surat Pengantar RT
- Surat Tidak Mampu: NIK, KTP, Surat Pengantar RT, Surat Rekomendasi Kelurahan
- Surat Pengalaman: NIK, KTP, Surat Pengantar RT, Dokumen Pendukung

Jadwal Pelayanan:
- Senin - Jumat: 08:00 - 16:00
- Sabtu: 08:00 - 12:00
- Minggu & Hari Libur: Tutup

Prosedur:
1. Warga datang dan mengajukan permohonan
2. Admin memverifikasi data dan dokumen
3. Surat diproses dalam 1-3 hari kerja
4. Warga dihubungi untuk pengambilan
PROMPT;
    }

    /**
     * Get current model being used
     */
    public function getModel(): string
    {
        return $this->model;
    }
}

