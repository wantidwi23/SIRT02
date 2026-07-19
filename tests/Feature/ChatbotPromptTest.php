<?php

namespace Tests\Feature;

use App\Models\GeminiConfig;
use App\Services\GeminiChatbotService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Pengujian Chatbot RT - LLM Response Validation
 *
 * Metode: Validasi berbasis keyword + simpan hasil ke JSON untuk dokumentasi skripsi.
 * Output JSON tersimpan di: storage/logs/chatbot_test_result.json
 */
class ChatbotPromptTest extends TestCase
{
    protected GeminiChatbotService $service;

    /** @var array<string, mixed> Akumulasi hasil tes untuk disimpan ke JSON */
    protected static array $testResults = [];

    protected function setUp(): void
    {
        parent::setUp();

        $activeConfig = GeminiConfig::where('is_active', true)->first();
        if (!$activeConfig) {
            $this->markTestSkipped('Tidak ada konfigurasi Gemini API yang aktif. Test dilewati.');
        }

        $this->service = new GeminiChatbotService();
    }

    #[DataProvider('chatbotQuestionsProvider')]
    public function test_chatbot_menjawab_sesuai_konteks_rt(string $question): void
    {
        $startTime = microtime(true);

        // 1. Panggil API chatbot
        $response = $this->service->getResponse($question);
        $duration = round(microtime(true) - $startTime, 2);

        $result = [
            'pertanyaan'    => $question,
            'status_api'    => $response['success'] ? 'sukses' : 'gagal',
            'jawaban'       => $response['success'] ? $response['message'] : null,
            'error'         => $response['success'] ? null : ($response['error'] ?? 'unknown'),
            'durasi_detik'  => $duration,
            'validasi'      => [],
            'hasil_akhir'   => 'LULUS',
        ];

        // 2. Pastikan API berhasil
        if (!$response['success']) {
            $result['hasil_akhir'] = 'GAGAL';
            $result['validasi'][]  = ['cek' => 'API call', 'status' => 'GAGAL', 'keterangan' => $result['error']];
            self::$testResults[]   = $result;
            $this->saveJsonReport();
            $this->fail("API gagal untuk: \"{$question}\"\nError: " . $result['error']);
        }

        $answer = $response['message'];

        // 3. Validasi jawaban tidak kosong
        $v1 = !empty(trim($answer));
        $result['validasi'][] = ['cek' => 'Jawaban tidak kosong', 'status' => $v1 ? 'LULUS' : 'GAGAL'];

        // 4. Validasi menggunakan Bahasa Indonesia
        $biWords = ['dan','atau','yang','untuk','dengan','di','ke','dari','ini','itu',
                    'ada','bisa','tidak','jika','maka','saya','anda','kami','pada','akan',
                    'silakan','mohon','cara','melalui','halaman','menu','klik'];
        $foundBI = false;
        foreach ($biWords as $kw) {
            if (str_contains(strtolower($answer), $kw)) { $foundBI = true; break; }
        }
        $result['validasi'][] = ['cek' => 'Bahasa Indonesia', 'status' => $foundBI ? 'LULUS' : 'GAGAL'];

        // 5. Validasi tidak menolak dalam bahasa Inggris
        $failPhrases = ["i cannot", "i am unable", "as an ai, i", "i'm sorry, i can't", "i don't have"];
        $isEnglishRefusal = false;
        foreach ($failPhrases as $p) {
            if (stripos($answer, $p) !== false) { $isEnglishRefusal = true; break; }
        }
        $result['validasi'][] = ['cek' => 'Tidak menolak dalam bahasa Inggris', 'status' => !$isEnglishRefusal ? 'LULUS' : 'GAGAL'];

        // Tentukan hasil akhir
        $allPass = $v1 && $foundBI && !$isEnglishRefusal;
        $result['hasil_akhir'] = $allPass ? 'LULUS' : 'GAGAL';

        self::$testResults[] = $result;
        $this->saveJsonReport();

        // Jeda 4 detik (API gratis Gemini ~15 req/min)
        sleep(4);

        // Jalankan assertions PHPUnit
        $this->assertTrue($v1,            "Jawaban kosong untuk: \"{$question}\"");
        $this->assertTrue($foundBI,        "Jawaban tidak ber-BI untuk: \"{$question}\"");
        $this->assertFalse($isEnglishRefusal, "Bot menolak dalam bahasa Inggris untuk: \"{$question}\"\nJawaban: {$answer}");
    }

    /**
     * Simpan akumulasi hasil ke file JSON setelah setiap tes.
     */
    private function saveJsonReport(): void
    {
        $lulus = count(array_filter(self::$testResults, fn($r) => $r['hasil_akhir'] === 'LULUS'));
        $gagal = count(array_filter(self::$testResults, fn($r) => $r['hasil_akhir'] === 'GAGAL'));

        $report = [
            'judul'           => 'Hasil Pengujian Chatbot Asisten RT - LLM Response Validation',
            'waktu_pengujian' => now()->format('Y-m-d H:i:s'),
            'total_pertanyaan'=> count(self::$testResults),
            'ringkasan'       => [
                'lulus' => $lulus,
                'gagal' => $gagal,
                'persentase_lulus' => count(self::$testResults) > 0
                    ? round(($lulus / count(self::$testResults)) * 100, 1) . '%'
                    : '0%',
            ],
            'detail_hasil'    => self::$testResults,
        ];

        file_put_contents(
            storage_path('logs/chatbot_test_result.json'),
            json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    public static function chatbotQuestionsProvider(): array
    {
        return [
            'Q01 - Administrasi RT'         => ['Membantu warga dalam pertanyaan tentang administrasi RT'],
            'Q02 - Persyaratan surat'        => ['Memberikan informasi persyaratan surat'],
            'Q03 - Prosedur dan jadwal'      => ['Menjelaskan prosedur dan jadwal pelayanan RT'],
            'Q04 - Laporan permasalahan'     => ['Menjawab pertanyaan seputar laporan dan permasalahan di RT'],
            'Q05 - Iuran bulanan'            => ['Menjawab pertanyaan seputar iuran bulanan RT'],
            'Q06 - Lapor lampu jalan'        => ['Bagaimana cara melapor lampu jalan'],
            'Q07 - Jadwal ronda'             => ['Di mana melihat jadwal ronda'],
            'Q08 - Fasilitas umum'           => ['Apa saja fasilitas umum di lingkungan RT?'],
            'Q09 - Download PDF surat'       => ['Apakah surat bisa di-download dalam bentuk PDF?'],
            'Q10 - Lama persetujuan surat'   => ['Berapa lama proses persetujuan surat online?'],
            'Q11 - Lupa password'            => ['Jika lupa password bagaimana?'],
            'Q12 - Hubungi ketua RT'         => ['Bagaimana cara menghubungi ketua RT melalui website?'],
            'Q13 - Lapor fasilitas rusak'    => ['Bagaimana cara melapor fasilitas rusak di lingkungan?'],
            'Q14 - Website di handphone'     => ['Apakah website sirt02 bisa digunakan di handphone?'],
            'Q15 - Cetak kartu keluarga'     => ['Bagaimana cara cetak kartu keluarga?'],
            'Q16 - Website 24 jam'           => ['Apakah website sirt02 bisa digunakan 24 jam?'],
            'Q17 - Lapor kehilangan barang'  => ['Cara melapor kehilangan barang?'],
            'Q18 - Daftar UMKM'              => ['Bagaimana cara mendaftarkan UMKM?'],
        ];
    }
}
