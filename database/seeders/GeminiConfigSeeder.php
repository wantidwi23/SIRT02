<?php

namespace Database\Seeders;

use App\Models\GeminiConfig;
use Illuminate\Database\Seeder;

class GeminiConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeminiConfig::create([
            'name' => 'Default Configuration',
            'api_key' => env('GEMINI_API_KEY', ''),
            'model' => 'gemini-pro',
            'temperature' => 0.7,
            'max_output_tokens' => 1024,
            'system_prompt' => $this->getDefaultSystemPrompt(),
            'is_active' => true,
            'description' => 'Konfigurasi default Gemini API untuk chatbot administrasi RT',
        ]);
    }

    private function getDefaultSystemPrompt(): string
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
}
