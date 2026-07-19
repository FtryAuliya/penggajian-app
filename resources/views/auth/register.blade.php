<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Aplikasi Penggajian</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
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

        .register-card {
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.30), 0 10px 20px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        .register-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.35);
        }

        /* HEADER */
        .register-header {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .register-header .logo-icon {
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

        .register-header h1 {
            font-weight: 700;
            font-size: 1.9rem;
            color: #0b2a4a;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .register-header p {
            color: #5e6f8d;
            font-weight: 400;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* FORM */
        .form-floating {
            margin-bottom: 1.25rem;
        }

        .form-floating > .form-control {
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            padding: 1rem 1rem 0.5rem 2.8rem;
            font-size: 0.95rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            background: #f8faff;
        }

        .form-floating > .form-control:focus {
            border-color: #1b4f8a;
            box-shadow: 0 0 0 4px rgba(27, 79, 138, 0.12);
            background: #ffffff;
        }

        .form-floating > .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
        }

        .form-floating > label {
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

        /* BUTTON */
        .btn-register {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #1b4f8a, #2a6fb0);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            box-shadow: 0 4px 15px rgba(27, 79, 138, 0.4);
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #0b2a4a, #1b4f8a);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(27, 79, 138, 0.5);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* LINK */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #5e6f8d;
        }

        .login-link a {
            color: #1b4f8a;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #0b2a4a;
            text-decoration: underline;
        }

        /* ERROR */
        .alert-danger {
            background: #fff0f0;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 0.8rem 1rem;
            color: #b02a37;
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-bottom: 1.2rem;
        }

        /* RESPONSIVE */
        @media (max-width: 480px) {
            .register-card {
                padding: 2rem 1.2rem;
                border-radius: 24px;
            }

            .register-header h1 {
                font-size: 1.6rem;
            }
        }

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
    </style>
</head>

<body>
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Buat Akun Baru</h1>
            <p>Daftar untuk mengakses Sistem Penggajian</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle mt-1"></i>
                <span>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </span>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="form-floating position-relative">
                <i class="fas fa-user input-icon"></i>
                <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nama Lengkap"
                    required autofocus autocomplete="name">
                <label for="name">Nama Lengkap</label>
            </div>

            <!-- Email -->
            <div class="form-floating position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="name@example.com"
                    required autocomplete="username">
                <label for="email">Alamat Email</label>
            </div>

            <!-- Password -->
            <div class="form-floating position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="Password"
                    required autocomplete="new-password"
                    minlength="8">
                <label for="password">Password</label>
            </div>
            <small class="text-muted d-block mb-3" style="margin-top: -0.8rem; padding-left: 0.5rem;">
                <i class="fas fa-info-circle me-1"></i> Minimal 8 karakter
            </small>

            <!-- Konfirmasi Password -->
            <div class="form-floating position-relative">
                <i class="fas fa-shield-alt input-icon"></i>
                <input id="password_confirmation" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation"
                    placeholder="Konfirmasi Password"
                    required autocomplete="new-password">
                <label for="password_confirmation">Konfirmasi Password</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register">
                <i class="fas fa-user-check"></i> Daftar Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
