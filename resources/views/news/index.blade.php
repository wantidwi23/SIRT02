<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Berita - Sistem Informasi Administrasi RT</title>
    <meta name="description" content="Daftar berita dan informasi terbaru dari Rukun Tetangga">
    <meta name="keywords" content="berita, RT, administrasi">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Questrial:wght@400&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">

    <style>
        :root {
            --color-sage: #A8D5BA;
            --color-yellow: #FFFACD;
            --color-light-green: #C5E8A0;
            --color-olive: #9BA88A;
            --color-dark: #2c3e50;
            --color-light: #f8f9fa;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        .page-header {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            color: var(--color-dark);
            padding: 60px 0;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 250, 205, 0.3);
            border-radius: 50%;
            z-index: 0;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(155, 168, 138, 0.2);
            border-radius: 50%;
            z-index: 0;
        }

        .page-header .container {
            position: relative;
            z-index: 1;
        }

        .page-header h1 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2.5rem;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.85;
            font-weight: 500;
        }

        /* News Cards */
        .news-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .news-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            z-index: 1;
        }

        .news-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 12px 32px rgba(168, 213, 186, 0.25);
        }

        .news-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 260px;
            background: linear-gradient(135deg, var(--color-light) 0%, var(--color-yellow) 100%);
        }

        .news-image {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.4s ease-in-out;
        }

        .news-card:hover .news-image {
            transform: scale(1.08);
        }

        .news-image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
        }

        .news-image-placeholder i {
            font-size: 3.5rem;
            color: rgba(44, 62, 80, 0.2);
        }

        .news-card-body {
            padding: 28px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .news-date {
            color: var(--color-olive);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .news-date i {
            color: var(--color-sage);
        }

        .news-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 10px 0;
            color: var(--color-dark);
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .news-card:hover .news-title {
            color: var(--color-sage);
        }

        .news-excerpt {
            color: #666;
            font-size: 0.95rem;
            margin: 12px 0;
            line-height: 1.6;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 2px solid var(--color-yellow);
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--color-sage);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            color: var(--color-olive);
            gap: 12px;
        }

        .read-more i {
            transition: transform 0.3s ease;
        }

        .read-more:hover i {
            transform: translateX(3px);
        }

        /* No News Section */
        .no-news {
            text-align: center;
            padding: 100px 40px;
            color: var(--color-olive);
        }

        .no-news-icon {
            font-size: 5rem;
            margin-bottom: 30px;
            color: var(--color-sage);
            opacity: 0.6;
        }

        .no-news h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 15px;
        }

        .no-news p {
            font-size: 1.05rem;
            color: var(--color-olive);
            margin-bottom: 30px;
        }

        .btn-back {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            border: none;
            color: white;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(168, 213, 186, 0.3);
            color: white;
        }

        /* Pagination */
        .pagination {
            gap: 8px;
        }

        .pagination .page-link {
            border: none;
            color: var(--color-sage);
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: var(--color-light);
        }

        .pagination .page-link:hover:not(.disabled) {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            color: white;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            border-color: var(--color-sage);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
                margin-bottom: 30px;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .page-header p {
                font-size: 0.95rem;
            }

            .news-card-body {
                padding: 20px;
            }

            .news-title {
                font-size: 1.15rem;
            }
        }

        [data-aos] {
            opacity: 0;
        }

        [data-aos].aos-animate {
            opacity: 1;
        }
    </style>
</head>

<body class="news-page">

    @include('partials.header')

    <main class="main" style="min-height: 70vh;">
        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <h1>Berita & Pengumuman</h1>
                <p>Informasi terbaru dari Rukun Tetangga</p>
            </div>
        </section>

        <!-- News Section -->
        <section id="news" class="py-5">
            <div class="container">
                @if($news->count() > 0)
                    <div class="row g-4">
                        @foreach($news as $item)
                            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="600">
                                <div class="card news-card h-100">
                                    <div class="news-image-wrapper">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="news-image">
                                        @else
                                            <div class="news-image-placeholder">
                                                <i class="bi bi-newspaper"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="news-card-body">
                                        <div class="news-meta">
                                            <i class="bi bi-calendar3"></i>
                                            <span class="news-date">{{ $item->published_at->format('d M Y') }}</span>
                                        </div>
                                        <h5 class="news-title">{{ $item->title }}</h5>
                                        <p class="news-excerpt">
                                            {{ Str::limit(strip_tags($item->content), 120, '...') }}
                                        </p>
                                        <div class="news-footer">
                                            <a href="{{ route('news.show', $item->slug) }}" class="read-more">
                                                Baca Selengkapnya 
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($news->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        {{-- Previous Page Link --}}
                                        @if ($news->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $news->previousPageUrl() }}">&laquo;</a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                            @if ($page == $news->currentPage())
                                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($news->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $news->nextPageUrl() }}">&raquo;</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="no-news">
                        <div class="no-news-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h3>Tidak Ada Berita</h3>
                        <p>Belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.</p>
                        <a href="{{ route('index') }}" class="btn btn-back mt-4">Kembali ke Beranda</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.footer')

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Chatbot Modal -->
    @if(auth()->check() || session('head_of_family_id'))
        @include('partials.chatbot-modal')
    @endif

    <script>
        AOS.init();
    </script>
</body>

</html>
