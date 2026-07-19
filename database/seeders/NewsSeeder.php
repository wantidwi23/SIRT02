<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            // Create an admin user if not exists
            $admin = User::create([
                'name' => 'Admin RT',
                'email' => 'admin@rt.local',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'active' => true,
            ]);
        }

        // Clear existing news
        News::truncate();

        $newsData = [
            [
                'title' => 'Pengumuman Perawatan Infrastruktur Jalan',
                'content' => 'Kami dengan senang hati mengumumkan bahwa akan dilakukan perawatan dan perbaikan infrastruktur jalan di lingkungan RT kami. Kegiatan ini dilakukan untuk meningkatkan kualitas dan keselamatan jalan yang digunakan oleh seluruh warga. Kami mohon maaf atas ketidaknyamanan yang mungkin terjadi selama proses perawatan berlangsung. Diharapkan kegiatan ini dapat selesai dalam waktu dua minggu. Untuk informasi lebih lanjut, silakan hubungi ketua RT atau kunjungi kantor RT kami.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Rapat Rutin Warga RT Bulan Januari',
                'content' => 'Pada hari Minggu, 25 Januari 2026, akan diadakan rapat rutin warga RT di balai pertemuan. Agenda rapat meliputi pembahasan pengelolaan dana iuran warga, program-program pembangunan lingkungan, dan evaluasi kegiatan tahun lalu. Kehadiran seluruh kepala keluarga sangat diharapkan untuk memastikan semua keputusan yang diambil mencerminkan aspirasi seluruh warga. Mari kita hadir dan berpartisipasi aktif.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Program Kesehatan Gratis untuk Warga',
                'content' => 'Berkaitan dengan komitmen kami dalam meningkatkan kesehatan warga RT, kami akan menyelenggarakan program pemeriksaan kesehatan gratis pada bulan Februari. Program ini mencakup pemeriksaan tekanan darah, pemeriksaan gula darah, dan konsultasi kesehatan umum. Untuk pendaftaran dan informasi lebih lanjut, silakan hubungi ketua RT atau kunjungi kantor RT kami. Fasilitas kesehatan profesional akan membantu dalam pemeriksaan ini.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Peluncuran Program Kebersihan Lingkungan',
                'content' => 'Dalam upaya menjaga kebersihan dan kelestarian lingkungan, kami meluncurkan program kebersihan lingkungan yang melibatkan seluruh warga. Program ini mencakup kegiatan gotong royong mingguan, pengelolaan sampah yang lebih baik, dan pemeliharaan taman komunitas. Setiap warga diharapkan dapat berpartisipasi aktif dalam program ini untuk menciptakan lingkungan yang lebih sehat dan indah. Jadwal kegiatan akan segera diumumkan.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Penghargaan untuk Warga Berprestasi',
                'content' => 'Kami dengan bangga memberikan penghargaan kepada beberapa warga yang telah menunjukkan kontribusi luar biasa terhadap pengembangan dan kemajuan lingkungan RT kami. Penghargaan ini diberikan sebagai bentuk apresiasi atas dedikasi dan kerja keras mereka dalam berbagai kegiatan RT. Semoga penghargaan ini dapat memotivasi semua warga untuk terus berkontribusi positif bagi kemajuan bersama.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Kegiatan Olahraga dan Rekreasi Keluarga',
                'content' => 'Pada bulan Februari, kami akan menyelenggarakan kegiatan olahraga dan rekreasi keluarga yang menyenangkan. Kegiatan ini dirancang untuk meningkatkan kebersamaan antar keluarga dan memperkuat hubungan sosial di lingkungan RT kami. Peserta dapat memilih berbagai cabang olahraga sesuai dengan minat dan kemampuan mereka. Daftar sekarang dan tunggu pengumuman lebih lanjut mengenai detail kegiatan dan biaya pendaftaran.',
                'status' => 'published',
                'published_at' => Carbon::now(),
            ],
        ];

        foreach ($newsData as $data) {
            News::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . Str::random(6),
                'content' => $data['content'],
                'user_id' => $admin->id,
                'image' => null,
                'published_at' => $data['published_at'],
                'status' => $data['status'],
            ]);
        }
    }
}

