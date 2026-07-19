<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIRT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
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
            background: #faf9f6;
            min-height: 100vh;
            font-family: 'Roboto', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: transparent;
            padding: 15px 0;
            box-shadow: none;
        }

        .login-page-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(74, 107, 95, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
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

        .login-header {
            background: linear-gradient(135deg, #6bb8a1 0%, #5a9b89 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
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

        .login-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .login-header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .login-body {
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

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(107, 184, 161, 0.35);
            background: linear-gradient(135deg, #5a9b89 0%, #4a8a79 100%);
        }

        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(107, 184, 161, 0.25);
        }

        .login-footer {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid rgba(107, 184, 161, 0.1);
        }

        .login-footer p {
            color: #5a5a52;
            font-size: 14px;
            margin: 0;
        }

        .login-footer a {
            color: #6bb8a1;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .login-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #6bb8a1;
            transition: width 0.3s ease;
        }

        .login-footer a:hover {
            color: #5a9b89;
        }

        .login-footer a:hover::after {
            width: 100%;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid rgba(220, 53, 69, 0.2);
            padding: 14px 16px;
            animation: slideDown 0.4s ease-out;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.02) 100%);
            color: #721c24;
        }

        .alert strong {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        .alert div {
            font-size: 14px;
            line-height: 1.5;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-text {
            font-size: 12px;
            color: #7a7a6f;
            margin-top: 6px;
        }

        .footer {
            background-color: white;
            margin-top: auto;
            border-top: 1px solid rgba(107, 184, 161, 0.1);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                border-radius: 12px;
                max-width: 100%;
            }

            .login-body {
                padding: 25px;
            }

            .login-header h2 {
                font-size: 1.8rem;
            }

            .login-header p {
                font-size: 0.95rem;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-page-wrapper {
                padding: 20px 15px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input {
                font-size: 16px;
                padding: 12px 14px;
            }

            .btn-login {
                padding: 12px 20px;
                font-size: 15px;
            }

            .login-footer p {
                font-size: 13px;
            }

            .form-text {
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                border-radius: 12px;
                max-width: 100%;
            }

            .login-body {
                padding: 20px;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }

            .login-header p {
                font-size: 0.9rem;
            }

            .login-header {
                padding: 25px 15px;
            }

            .login-page-wrapper {
                padding: 15px 12px;
            }

            .form-group label {
                font-size: 13px;
            }

            .form-group input {
                font-size: 16px;
                padding: 11px 12px;
            }

            .btn-login {
                padding: 11px 18px;
                font-size: 14px;
                margin-top: 8px;
            }

            .login-footer {
                padding-top: 16px;
            }

            .login-footer p {
                font-size: 12px;
            }

            .form-text {
                font-size: 10px;
            }

            .alert {
                padding: 12px 14px;
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .login-page-wrapper {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="login-page-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h2 style="color: white;">SIRT</h2>
                <p>Sistem Informasi Administrasi RT</p>
            </div>
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Login Gagal!</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login">Login</button>
                </form>

                <div class="login-footer">

                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
   