<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - SIRT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            background: white;
            min-height: 100vh;
            font-family: 'Roboto', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }

        #header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        main {
            flex: 1;
        }

        .page-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .container-form {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(74, 107, 95, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            animation: slideUp 0.5s ease-out;
            border: 1px solid rgba(107, 184, 161, 0.1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            background: linear-gradient(135deg, #6bb8a1 0%, #5a9b89 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .form-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 2rem;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .form-header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .form-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #4a6b5f;
            display: block;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .form-group input {
            border: 2px solid rgba(107, 184, 161, 0.2);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fafaf6 0%, rgba(245, 230, 200, 0.3) 100%);
            color: #5a5a52;
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6bb8a1;
            box-shadow: 0 0 0 4px rgba(107, 184, 161, 0.1);
            background: white;
        }

        .form-group input.is-invalid {
            border-color: #dc3545;
        }

        .form-group input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
            color: #155724;
        }

        .btn-submit {
            background: linear-gradient(135deg, #6bb8a1 0%, #5a9b89 100%);
            border: none;
            border-radius: 10px;
            padding: 14px 24px;
            color: white;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 20px rgba(107, 184, 161, 0.25);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(107, 184, 161, 0.35);
            background: linear-gradient(135deg, #5a9b89 0%, #4a8a79 100%);
        }

        .btn-submit:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(107, 184, 161, 0.25);
        }

        .btn-back {
            background: transparent;
            border: 2px solid rgba(107, 184, 161, 0.3);
            border-radius: 10px;
            padding: 12px 24px;
            color: #6bb8a1;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn-back:hover {
            background: rgba(107, 184, 161, 0.1);
            border-color: #6bb8a1;
        }

        .form-footer {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid rgba(107, 184, 161, 0.1);
        }

        .form-footer p {
            color: #5a5a52;
            font-size: 14px;
        }

        .form-footer a {
            color: #6bb8a1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #5a9b89;
            text-decoration: underline;
        }

        .password-info {
            background: rgba(107, 184, 161, 0.05);
            border-left: 4px solid #6bb8a1;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #4a6b5f;
            line-height: 1.6;
        }

        .password-info strong {
            color: #5a9b89;
        }

        @media (max-width: 480px) {
            .form-header h2 {
                font-size: 1.5rem;
            }

            .form-body {
                padding: 30px 20px;
            }

            .container-form {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main">
        <div class="page-wrapper">
        <div class="container-form">
            <div class="form-header">
                <h2>Ubah Password</h2>
                <p>Perbarui kata sandi akun Anda</p>
                <small style="opacity: 0.9;">
                    @if (session('head_of_family_id'))
                        {{ session('head_of_family_name') }}
                    @elseif (auth()->user())
                        {{ auth()->user()->name }}
                    @endif
                </small>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="password-info">
                    <strong>Persyaratan Password:</strong><br>
                    • Minimal 8 karakter<br>
                    • 1 huruf besar (A-Z)<br>
                    • 1 angka (0-9)<br>
                    • 1 karakter spesial (!@#$%^&*)
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input 
                            type="password" 
                            class="form-control @error('current_password') is-invalid @enderror" 
                            id="current_password" 
                            name="current_password" 
                            placeholder="Masukkan password saat ini"
                            required
                        >
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password baru"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Konfirmasi password baru"
                            required
                        >
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-lock"></i> Ubah Password
                    </button>
                </form>

             
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
