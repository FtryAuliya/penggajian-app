<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Aplikasi Penggajian</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-
alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-
awesome/6.0.0/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap
" rel="stylesheet">
    <style>
        /* ========================================
GLOBAL STYLES
======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #0b2a4a 0%, #1b4f8a 50%, #2a6fb0 100%);
            background-attachment: fixed;
            padding: 20px;
        }

        /* ========================================
LOGIN CARD
======================================== */
        .login-card {
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.30), 0 10px 20px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.35);
        }

        /* ========================================
HEADER
======================================== */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #1b4f8a, #2a6fb0);
            border-radius: 20px;
            color: white;
            font-size: 2.2rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 8px 20px rgba(27, 79, 138, 0.35);
        }

        .login-header h1 {
            font-weight: 700;
            font-size: 1.9rem;
            color: #0b2a4a;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            color: #5e6f8d;
            font-weight: 400;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* ========================================
FORM
======================================== */
        .form-floating {
            margin-bottom: 1.25rem;
        }

        .form-floating>.form-control {
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            padding: 1rem 1rem 0.5rem 2.8rem;
            font-size: 0.95rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            background: #f8faff;
        }

        .form-floating>.form-control:focus {
            border-color: #1b4f8a;
            box-shadow: 0 0 0 4px rgba(27, 79, 138, 0.12);
            background: #ffffff;
        }

        .form-floating>.form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
        }

        .form-floating>label {
            padding-left: 2.8rem;
            font-weight: 500;
            color: #5e6f8d;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8a9bb5;
            font-size: 1.1rem;
            z-index: 4;
            pointer-events: none;
        }

        /* ========================================
REMEMBER & FORGOT
======================================== */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .form-options .form-check {
            display: flex;
            align-items: center;
        }

        .form-options .form-check-input {
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
        }

        .form-options .form-check-input:checked {
            background-color: #1b4f8a;
            border-color: #1b4f8a;
        }

        .form-options .form-check-label {
            font-size: 0.9rem;
            color: #3d4e6b;
            cursor: pointer;
            margin-left: 0.4rem;
        }

        .form-options a {
            color: #1b4f8a;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .form-options a:hover {
            color: #0b2a4a;
            text-decoration: underline;
        }

        /* ========================================
BUTTON
======================================== */
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 14px;
            background: linear-gradient(135deg, #1b4f8a, #2a6fb0);
            border: none;
            color: white;
            transition: all 0.25s ease;
            box-shadow: 0 6px 18px rgba(27, 79, 138, 0.30);
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #143d6e, #1b4f8a);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(27, 79, 138, 0.40);
        }

        .btn-login:active {
            transform: translateY(1px);
            box-shadow: 0 4px 12px rgba(27, 79, 138, 0.25);
        }

        .btn-login i {
            margin-right: 0.5rem;
        }

        /* ========================================
REGISTER LINK
======================================== */
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #5e6f8d;
        }

        .register-link a {
            color: #1b4f8a;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #0b2a4a;
            text-decoration: underline;
        }

        /* ========================================
ERROR MESSAGES
======================================== */
        .alert-danger {
            background: #fee9e9;
            border: none;
            border-radius: 14px;
            padding: 0.8rem 1rem;
            color: #b02a37;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.2rem;
        }

        .alert-danger i {
            font-size: 1.1rem;
        }

        /* ========================================
RESPONSIVE
======================================== */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.2rem;
                border-radius: 24px;
            }

            .login-header h1 {
                font-size: 1.6rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Animasi subtle */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <h1>Aplikasi Penggajian</h1>
            <p>Sistem Informasi Penggajian Pegawai</p>
        </div>
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </span>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success" style="border-radius:14px; border:none;">
                {{ session('status') }}
            </div>
        @endif
        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            <div class="form-floating position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus
                    autocomplete="username">
                <label for="email">Alamat Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Password" required autocomplete="current-password">
                <label for="password">Password</label>
            </div>
            <!-- Remember & Forgot -->
            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <!-- Submit -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>
        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
