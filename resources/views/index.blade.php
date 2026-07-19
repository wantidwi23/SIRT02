<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistem Informasi Administrasi RT</title>
  <meta name="description" content="Sistem Informasi Administrasi RT - Pengelolaan administrasi Rukun Tetangga dengan Chatbot AI">
  <meta name="keywords" content="RT, administrasi, chatbot">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Questrial:wght@400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/responsive.css" rel="stylesheet">
</head>

<body class="index-page">

  @include('partials.header')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center content">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h2>Sistem Informasi<br><span style="color: #6bb8a1;">Administrasi RT</span></h2>
            <p class="lead">Solusi digital modern untuk pengelolaan administrasi Rukun Tetangga yang lebih efisien dan terpercaya dengan teknologi terkini</p>
            <div class="cta-buttons" data-aos="fade-up" data-aos-delay="300">
              @if(auth()->check() || session('head_of_family_id'))
                @if(session('head_of_family_id'))
                  <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Dashboard</a>
                @elseif(auth()->user()->role === 'admin')
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard Admin</a>
                @else
                  <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @endif
                <a href="{{ route('chatbot.index') }}" class="btn btn-outline">Konsultasi dengan Bot</a>
              @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
              @endif
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image">
              <img src="assets/img/bg.png" alt="Portfolio Hero Image" class="img-fluid" data-aos="zoom-out" data-aos-delay="300">
              <div class="shape-1"></div>
              <div class="shape-2"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Vision Mission Section -->
    <section id="vision-mission" class="vision-mission section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Visi & Misi</h2>
          <p>Komitmen kami dalam melayani masyarakat</p>
        </div>

        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="vision-mission-card vision-card">
              <div class="vision-mission-icon">
                <i class="bi bi-eye"></i>
              </div>
              <h3>Visi</h3>
              <p>Mewujudkan Rukun Tetangga yang harmonis, transparan, dan berbasis teknologi digital untuk meningkatkan kualitas hidup dan kesejahteraan masyarakat</p>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="vision-mission-card mission-card">
              <div class="vision-mission-icon">
                <i class="bi bi-target"></i>
              </div>
              <h3>Misi</h3>
              <ul class="mission-list">
                <li><i class="bi bi-check-circle-fill"></i> Menyediakan platform digital untuk pengelolaan administrasi RT yang efisien</li>
                <li><i class="bi bi-check-circle-fill"></i> Meningkatkan komunikasi dan transparansi antar warga dan pengurus RT</li>
                <li><i class="bi bi-check-circle-fill"></i> Mempercepat proses pelayanan administratif kepada seluruh warga</li>
                <li><i class="bi bi-check-circle-fill"></i> Memberdayakan masyarakat melalui teknologi informasi</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Fitur Utama</h2>
          <p>Sistem Informasi Administrasi RT dengan berbagai fitur pendukung</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-item">
              <i class="bi bi-people"></i>
              <h3>Pendataan Warga</h3>
              <p>Kelola data warga secara terpusat dengan informasi lengkap dan terstruktur</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-item">
              <i class="bi bi-file-text"></i>
              <h3>Pembuatan Surat</h3>
              <p>Proses pembuatan surat keterangan, domisili, dan dokumen penting lainnya</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-item">
              <i class="bi bi-exclamation-circle"></i>
              <h3>Pelaporan Warga</h3>
              <p>Warga dapat melaporkan masalah atau kejadian yang perlu ditangani RT</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-item">
              <i class="bi bi-chat-dots"></i>
              <h3>Chatbot Asisten</h3>
              <p>Dapatkan informasi administrasi dan persyaratan surat 24/7 melalui chatbot AI</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="feature-item">
              <i class="bi bi-shield-check"></i>
              <h3>Keamanan Data</h3>
              <p>Data terenkripsi dan terlindungi dengan sistem keamanan berlapis</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="feature-item">
              <i class="bi bi-graph-up"></i>
              <h3>Laporan & Analitik</h3>
              <p>Analisis data dan laporan komprehensif untuk pengambilan keputusan</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistics" class="statistics section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Statistik Warga</h2>
          <p>Data jumlah warga RT saat ini</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card text-center">
              <div class="stats-icon">
                <i class="bi bi-people"></i>
              </div>
              <h3>{{ $totalResidents }}</h3>
              <p>Total Warga</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card text-center">
              <div class="stats-icon male">
                <i class="bi bi-person"></i>
              </div>
              <h3>{{ $maleResidents }}</h3>
              <p>Warga Laki-laki</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card text-center">
              <div class="stats-icon female">
                <i class="bi bi-person"></i>
              </div>
              <h3>{{ $femaleResidents }}</h3>
              <p>Warga Perempuan</p>
            </div>
          </div>
        </div>
      </div>
    </section>

   

  </main>

 
   

    

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section testimonial-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Struktur Pengurus RT</h2>
        <div class="title-shape">
          <svg viewBox="0 0 200 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M 0,10 C 40,0 60,20 100,10 C 140,0 160,20 200,10" fill="none" stroke="currentColor" stroke-width="2"></path>
          </svg>
        </div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="org-chart">
              <!-- Level 1: KETUA -->
              <div class="org-level level-1" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <div class="org-card text-center">
                      <div class="org-card-header bg-primary">
                        <i class="bi bi-person-fill" style="font-size: 2rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h5 class="mb-2">KETUA</h5>
                        <p class="mb-0 fw-bold">Hudariati</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- SVG Connector - Level 1 to Level 2 -->
              <svg class="connector-svg" viewBox="0 0 100 80" preserveAspectRatio="none">
                <line x1="50" y1="0" x2="50" y2="30" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="50" y1="30" x2="20" y2="30" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="50" y1="30" x2="80" y2="30" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="20" y1="30" x2="20" y2="80" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="80" y1="30" x2="80" y2="80" stroke="#6bb8a1" stroke-width="2"/>
              </svg>

              <!-- Level 2: Sekretaris & Bendahara -->
              <div class="org-level level-2" data-aos="fade-up" data-aos-delay="150">
                <div class="row justify-content-center g-4">
                  <div class="col-lg-3">
                    <div class="org-card text-center">
                      <div class="org-card-header bg-success">
                        <i class="bi bi-file-text" style="font-size: 2rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h5 class="mb-2">SEKRETARIS</h5>
                        <p class="mb-0 fw-bold">Fikri Ubaydillah</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="org-card text-center">
                      <div class="org-card-header bg-warning">
                        <i class="bi bi-cash-coin" style="font-size: 2rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h5 class="mb-2">BENDAHARA</h5>
                        <p class="mb-0 fw-bold">Vitri Prahantini</p>
                        <p class="mb-0 fw-bold">Tri Tusiwartini</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- SVG Connector - Level 2 to Level 3 -->
              <svg class="connector-svg-large" viewBox="0 0 100 100" preserveAspectRatio="none">
                <line x1="25" y1="0" x2="25" y2="35" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="75" y1="0" x2="75" y2="35" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="8" y1="35" x2="92" y2="35" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="12" y1="35" x2="12" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="27" y1="35" x2="27" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="42" y1="35" x2="42" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="58" y1="35" x2="58" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="73" y1="35" x2="73" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="85" y1="35" x2="85" y2="100" stroke="#6bb8a1" stroke-width="2"/>
                <line x1="92" y1="35" x2="92" y2="100" stroke="#6bb8a1" stroke-width="2"/>
              </svg>

              <!-- Level 3: Bidang-Bidang -->
              <div class="org-level level-3" data-aos="fade-up" data-aos-delay="200">
                <div class="row g-2 bidang-row">
                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-info">
                        <i class="bi bi-people" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang Humas</h6>
                        <p class="mb-1 small">Subiyanto</p>
                        <p class="mb-0 small">yuliantrini</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-info">
                        <i class="bi bi-building" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang Keagamaan</h6>
                        <p class="mb-1 small">Matsani</p>
                        <p class="mb-0 small">Nachrowi</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-danger">
                        <i class="bi bi-shield-exclamation" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang Pemuda & Olahraga</h6>
                        <p class="mb-1 small">Joni Akta</p>
                        <p class="mb-0 small">Dwi Wanti</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-secondary">
                        <i class="bi bi-book" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang Pendidikan IT dan UKM</h6>
                        <p class="mb-1 small">Jani Sabtriady</p>
                        <p class="mb-0 small">yuyun Suhaedah</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-success">
                        <i class="bi bi-tree" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang PLKH</h6>
                          <p class="mb-1 small">Kuswa</p>
                        <p class="mb-0 small">Khoiri</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-info">
                        <i class="bi bi-heart" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang PKK & Posyandu</h6>
                        <p class="mb-1 small">Susi H</p>
                        <p class="mb-0 small">Hamidah</p>
                      </div>
                    </div>
                  </div>

                  <div class="bidang-col">
                    <div class="org-card">
                      <div class="org-card-header bg-primary">
                        <i class="bi bi-shield-check" style="font-size: 1.4rem; color: white;"></i>
                      </div>
                      <div class="org-card-body">
                        <h6 class="mb-2">Bidang Keamanan</h6>
                         <p class="mb-1 small">M. Fajrin</p>
                        <p class="mb-0 small">Hasan Bakar</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Testimonials Section -->

    

    <!-- News Section -->
    <section id="berita" class="berita section berita-background">

      <div class="container section-title" data-aos="fade-up">
        <h2>Berita Terbaru</h2>
        <div class="title-shape">
          <svg viewBox="0 0 200 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M 0,10 C 40,0 60,20 100,10 C 140,0 160,20 200,10" fill="none" stroke="currentColor" stroke-width="2"></path>
          </svg>
        </div>
        <p>Informasi terkini dan update berita penting dari komunitas RT kami</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
          @forelse($latestNews as $index => $item)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
              <div class="news-card">
                <div class="news-image">
                  @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                  @else
                    <div style="background: linear-gradient(135deg, #A8D5BA 0%, #C5E8A0 100%); height: 250px; display: flex; align-items: center; justify-content: center;">
                      <i class="bi bi-newspaper" style="font-size: 3rem; color: rgba(44, 62, 80, 0.2);"></i>
                    </div>
                  @endif
                  <span class="news-date">{{ $item->published_at->format('d M Y') }}</span>
                </div>
                <div class="news-content">
                  <div class="news-category">
                    @if(str_contains($item->title, 'Pengumuman'))
                      Pengumuman
                    @elseif(str_contains($item->title, 'Program'))
                      Program
                    @elseif(str_contains($item->title, 'Rapat'))
                      Rapat
                    @elseif(str_contains($item->title, 'Renovasi') || str_contains($item->title, 'Perbaikan'))
                      Infrastruktur
                    @elseif(str_contains($item->title, 'Kesehatan'))
                      Kesehatan
                    @elseif(str_contains($item->title, 'Kebersihan'))
                      Lingkungan
                    @elseif(str_contains($item->title, 'Olahraga') || str_contains($item->title, 'Rekreasi'))
                      Kegiatan
                    @else
                      Pengumuman
                    @endif
                  </div>
                  <h3>{{ $item->title }}</h3>
                  <p>{{ Str::limit(strip_tags($item->content), 100, '...') }}</p>
                  <a href="{{ route('news.show', $item->slug) }}" class="read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">Belum ada berita yang tersedia</p>
            </div>
          @endforelse
        </div>

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="700">
          <a href="{{ route('news.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
        </div>
      </div>

    </section><!-- /News Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section testimonial-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <div class="title-shape">
          <svg viewBox="0 0 200 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M 0,10 C 40,0 60,20 100,10 C 140,0 160,20 200,10" fill="none" stroke="currentColor" stroke-width="2"></path>
          </svg>
        </div>
        <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum qui dolorem</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                <div class="faq-content">
                  <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                <div class="faq-content">
                  <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                <div class="faq-content">
                  <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                <div class="faq-content">
                  <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Maps Section -->
    <section id="maps" class="maps section berita-background">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Lokasi Rumah Ketua RT</h2>
          <div class="title-shape">
            <svg viewBox="0 0 200 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M 0,10 C 40,0 60,20 100,10 C 140,0 160,20 200,10" fill="none" stroke="currentColor" stroke-width="2"></path>
            </svg>
          </div>
          <p>Lokasi rumah Ketua RT untuk keperluan administrasi dan konsultasi masyarakat</p>
        </div>

        <div class="row align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-6">
            <div class="maps-container">
              <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d247.8320073491402!2d106.85269259787869!3d-6.353625682069832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMjEnMTMuNSJTIDEwNsKwNTEnMTAuMiJF!5e0!3m2!1sen!2sid!4v1769668063616!5m2!1sen!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center">
            <div class="maps-content">
              <h3>Rumah Ketua RT</h3>
              <div class="maps-info">
                <div class="maps-info-item" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <div>
                    <h4>Alamat</h4>
                    <p>Jl. Rukun Tetangga No. 123<br>Kota/Kabupaten, Provinsi 12345</p>
                  </div>
                </div>

                <div class="maps-info-item" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <div>
                    <h4>Nomor Telepon</h4>
                    <p>+62 812-3456-7890<br>+62 274-1234567</p>
                  </div>
                </div>

                <div class="maps-info-item" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-clock"></i>
                  <div>
                    <h4>Jam Konsultasi</h4>
                    <p>Senin - Jumat: 09:00 - 17:00<br>Sabtu: 09:00 - 12:00</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Maps Section -->

    
  </main>

  @include('partials.footer')

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Chatbot Modal -->
  @if(auth()->check() || session('head_of_family_id'))
    @include('partials.chatbot-modal')
  @endif

</body>

</html>
