<?php

namespace App\Http\Controllers;

use App\Models\ChatbotConversation;
use App\Services\GeminiChatbotService;
use App\Models\GeminiConfig;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    private GeminiChatbotService $chatbotService;

    public function __construct(GeminiChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Generate a simple fallback reply based on the active GeminiConfig->system_prompt.
     * Tries to find relevant sections (Persyaratan Surat, Jadwal Pelayanan, Prosedur, dll)
     */
    protected function generateFallbackReply(string $userMessage): ?string
    {
        try {
            $config = GeminiConfig::getActive();
            if (!$config || empty($config->system_prompt)) {
                return null;
            }

            $prompt = $config->system_prompt;
            $lower = mb_strtolower($userMessage);

            // Map keywords to simple heuristics
            $keywords = [
                'ktp' => 'Persyaratan umum untuk pengajuan surat pengantar KTP biasanya: NIK, fotokopi KTP, dan surat pengantar RT. Silakan lampirkan dokumen tersebut pada formulir pengajuan.',
                'pengantar' => 'Untuk mendapatkan surat pengantar, pilih menu Pengajuan Surat, isi formulir, dan lampirkan dokumen yang diminta. Admin RT akan memproses dalam 1–3 hari kerja.',
                'domisili' => 'Persyaratan surat keterangan domisili biasanya: fotokopi KTP, KK, dan surat pengantar RT. Lengkapi formulir di website atau datang ke sekretariat RT.',
                'jadwal' => 'Jadwal pelayanan: Senin–Jumat 08:00–16:00, Sabtu 08:00–12:00. Cek menu Jadwal pada halaman utama untuk detail.',
                'ronda' => 'Jadwal ronda dapat dilihat pada menu Jadwal atau pengumuman di halaman utama RT.',
                'lampu' => 'Untuk melapor lampu jalan yang rusak, gunakan menu Pelaporan dan isi lokasi serta unggah foto jika memungkinkan.',
                'pdf' => 'Ya, setelah surat disetujui, biasanya tersedia tombol Download PDF pada halaman rincian surat.',
                'persetujuan' => 'Proses persetujuan surat umumnya 1–3 hari kerja tergantung verifikasi dokumen oleh admin RT.',
                'password' => 'Klik "Lupa Password" pada halaman login dan ikuti instruksi reset melalui email atau NIK terdaftar.',
                'ketua' => 'Anda dapat menghubungi ketua RT melalui menu Kontak atau tombol Hubungi pada profil ketua di halaman utama.',
                'umkm' => 'Pendaftaran UMKM dapat dilakukan melalui menu Layanan → Pendaftaran UMKM, lengkapi data usaha dan unggah dokumen pendukung.',
                'hilang' => 'Untuk melapor kehilangan barang, buat laporan di menu Pelaporan dengan deskripsi dan bukti jika ada; admin akan membantu tindak lanjut.',
                'fasilitas' => 'Informasi fasilitas umum (lapangan, pos ronda, taman) tersedia di menu Fasilitas atau hubungi pengurus RT untuk detail.',
                'handphone' => 'Website dapat diakses melalui browser di handphone; tampilan responsif dioptimalkan untuk perangkat mobile.',
            ];

            foreach ($keywords as $k => $reply) {
                if (str_contains($lower, $k)) {
                    return $reply;
                }
            }

            // As a last resort, return a generic helpful message derived from prompt's first lines
            $firstLine = strtok(trim($prompt), "\n");
            if ($firstLine) {
                return "Saya tidak dapat menghubungi layanan eksternal sekarang. Namun saya dapat membantu: " . $firstLine;
            }

            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Show chatbot page
     */
    public function index(): View
    {
        return view('chatbot.index');
    }

    /**
     * Send message to chatbot
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
            'resident_id' => 'nullable|exists:residents,id',
        ]);

        try {
            $sessionId = $validated['session_id'] ?? Str::uuid()->toString();

            // Get atau create conversation
            $conversation = ChatbotConversation::where('session_id', $sessionId)
                ->first();

            if (!$conversation) {
                $conversation = new ChatbotConversation([
                    'session_id' => $sessionId,
                    'resident_id' => $validated['resident_id'] ?? null,
                    'messages' => [],
                ]);
            }

            // Add user message
            $conversation->addMessage('user', $validated['message']);

            // Get response dari Gemini
            $response = $this->chatbotService->getResponse(
                $validated['message'],
                $conversation->messages ?? []
            );

            // If external service failed with transient/quota errors, try local fallback
            $transientError = false;
            if (isset($response['error'])) {
                $err = strtolower($response['error']);
                if (str_contains($err, '503') || str_contains($err, 'service unavailable') || str_contains($err, 'high demand') || str_contains($err, '429') || str_contains($err, 'quota') || str_contains($err, 'too many requests')) {
                    $transientError = true;
                }
            }

            if (!$response['success'] && $transientError) {
                $fallback = $this->generateFallbackReply($validated['message']);
                if ($fallback) {
                    // store fallback as assistant message and return success
                    $conversation->addMessage('assistant', $fallback);
                    $conversation->save();

                    return response()->json([
                        'success' => true,
                        'message' => $fallback,
                        'session_id' => $sessionId,
                        'conversation' => $conversation->messages,
                        'fallback' => true,
                    ]);
                }
            }

            if (!$response['success']) {
                $payload = [
                    'success' => false,
                    'message' => $response['message'],
                    'session_id' => $sessionId,
                ];

                // Include debug error when app in debug mode
                if (config('app.debug') && isset($response['error'])) {
                    $payload['error'] = $response['error'];
                }

                return response()->json($payload, 400);
            }

            // Add bot response
            $conversation->addMessage('assistant', $response['message']);
            $conversation->save();

            return response()->json([
                'success' => true,
                'message' => $response['message'],
                'session_id' => $sessionId,
                'conversation' => $conversation->messages,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get conversation history
     */
    public function getConversation(Request $request): JsonResponse
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Session ID required',
            ], 400);
        }

        $conversation = ChatbotConversation::where('session_id', $sessionId)->first();

        if (!$conversation) {
            return response()->json([
                'success' => true,
                'messages' => [],
                'session_id' => $sessionId,
            ]);
        }

        return response()->json([
            'success' => true,
            'messages' => $conversation->messages ?? [],
            'session_id' => $sessionId,
        ]);
    }

    /**
     * Clear conversation
     */
    public function clearConversation(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id');

        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Session ID required',
            ], 400);
        }

        ChatbotConversation::where('session_id', $sessionId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Conversation cleared',
        ]);
    }
}
