<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $news->title }} - Sistem Informasi Administrasi RT</title>
    <meta name="description" content="{{ Str::limit($news->content, 160) }}">
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

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            color: var(--color-dark);
            padding: 80px 0 60px 0;
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
            margin-bottom: 15px;
            font-size: 2.5rem;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            color: var(--color-olive);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--color-dark);
            gap: 12px;
        }

        .article-meta {
            color: var(--color-olive);
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .article-meta i {
            color: var(--color-sage);
        }

        /* Main Content */
        .article-container {
            max-width: 820px;
            margin: 0 auto;
        }

        .article-image {
            width: 100%;
            height: auto;
            border-radius: 20px;
            margin-bottom: 50px;
            box-shadow: 0 15px 40px rgba(168, 213, 186, 0.25);
            border: 2px solid var(--color-yellow);
            overflow: hidden;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.85;
            color: #333;
            margin-bottom: 40px;
        }

        .article-content p {
            margin-bottom: 25px;
            text-align: justify;
        }

        .article-content p:first-letter {
            font-weight: 600;
            color: var(--color-sage);
        }

        /* Article Info Box */
        .article-info {
            background: linear-gradient(135deg, rgba(168, 213, 186, 0.1) 0%, rgba(197, 232, 160, 0.1) 100%);
            border: 2px solid var(--color-light-green);
            border-radius: 16px;
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
            backdrop-filter: blur(10px);
        }

        .article-info-item {
            margin-bottom: 30px;
        }

        .article-info-item:last-child {
            margin-bottom: 0;
        }

        .article-info-label {
            color: var(--color-olive);
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .article-info-label i {
            color: var(--color-sage);
            font-size: 1.1rem;
        }

        .article-info-value {
            color: var(--color-dark);
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Article Section Background */
        .article-section {
            background-color: var(--color-light);
        }

        /* Back Button */
        .btn-back {
            background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            border: none;
            color: white;
            padding: 14px 32px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(168, 213, 186, 0.35);
            color: white;
            text-decoration: none;
        }

        .btn-back i {
            transition: transform 0.3s ease;
        }

        .btn-back:hover i {
            transform: translateX(-3px);
        }

        /* Related Articles Section */
        .related-section {
            margin-top: 80px;
            padding-top: 60px;
            border-top: 3px solid var(--color-yellow);
        }

        .related-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }

        .related-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--color-sage) 0%, var(--color-light-green) 100%);
            border-radius: 2px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 60px 0 40px 0;
                margin-bottom: 30px;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .article-content {
                font-size: 1rem;
                line-height: 1.7;
            }

            .article-info {
                padding: 25px;
            }

            .article-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body class="index-page">

    @include('partials.header')

    <main class="main">
        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <a href="{{ route('news.index') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali ke Berita
                </a>
                <h1>{{ $news->title }}</h1>
                <div class="article-meta">
                    <i class="bi bi-calendar-event"></i> {{ $news->published_at->format('d F Y H:i') }}
                    <span class="ms-3">
                        <i class="bi bi-person"></i> {{ $news->user->name }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Article Section -->
        <section class="py-5 article-section">
            <div class="container article-container">
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="article-image">
                @else
                    <div class="article-image" style="background: linear-gradient(135deg, var(--color-sage) 0%, var(--color-light-green) 100%); display: flex; align-items: center; justify-content: center; height: 400px;">
                        <i class="bi bi-newspaper" style="font-size: 5rem; color: rgba(44, 62, 80, 0.2);"></i>
                    </div>
                @endif

                <div class="article-content">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <div class="article-info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="article-info-item">
                                <div class="article-info-label">
                                    <i class="bi bi-person-circle"></i> Penulis
                                </div>
                                <div class="article-info-value">{{ $news->user->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="article-info-item">
                                <div class="article-info-label">
                                    <i class="bi bi-calendar-event"></i> Dipublikasikan
                                </div>
                                <div class="article-info-value">{{ $news->published_at->format('d F Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="article-info-item">
                                <div class="article-info-label">
                                    <i class="bi bi-arrow-repeat"></i> Terakhir Diperbarui
                                </div>
                                <div class="article-info-value">{{ $news->updated_at->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 mb-5">
                    <a href="{{ route('news.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                    </a>
                </div>
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
