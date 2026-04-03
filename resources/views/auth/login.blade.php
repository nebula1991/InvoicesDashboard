<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceder · Facturación</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">

    <style>
        body {
            background: #f7f5f3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* Logo / marca */
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInUp 0.5s ease forwards;
        }
        .login-brand .brand-icon {
            width: 56px;
            height: 56px;
            background: var(--color-navbar-bg);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 8px 24px rgba(44, 40, 37, 0.25);
        }
        .login-brand h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-text);
            margin: 0;
        }
        .login-brand p {
            color: var(--color-text-muted);
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* Card del formulario */
        .login-card {
            border: 1px solid var(--color-border) !important;
            border-radius: 16px !important;
            box-shadow: 0 16px 48px rgba(60, 50, 40, 0.10) !important;
            background: white;
            animation: fadeInUp 0.5s ease 0.1s forwards;
            opacity: 0;
        }

        /* Separador decorativo superior */
        .login-card::before {
            content: '';
            display: block;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
            border-radius: 16px 16px 0 0;
        }

        .login-card .card-body {
            padding: 2rem;
        }

        /* Input con icono */
        .input-group .input-group-text {
            background: var(--color-stone) !important;
            border-right: none !important;
            color: var(--color-text-muted);
        }
        .input-group .form-control {
            border-left: none !important;
        }
        .input-group .form-control:focus {
            border-color: var(--color-border) !important;
            box-shadow: none !important;
        }
        .input-group:focus-within {
            border-radius: var(--radius-sm);
            box-shadow: 0 0 0 3px rgba(124, 156, 191, 0.15);
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--color-primary) !important;
        }

        /* Botón submit */
        .btn-login {
            background: var(--color-navbar-bg) !important;
            border: none !important;
            color: white !important;
            padding: 0.7rem 1rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: var(--transition);
        }
        .btn-login:hover {
            background: #3d3530 !important;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(44, 40, 37, 0.2);
        }

        /* Footer del login */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--color-text-muted);
            animation: fadeInUp 0.5s ease 0.2s forwards;
            opacity: 0;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">

        {{-- Marca --}}
        <div class="login-brand">
            <div class="brand-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
            <h1>Sistema de Facturación</h1>
            <p>Accede a tu cuenta para continuar</p>
        </div>

        {{-- Card --}}
        <div class="login-card card">
            <div class="card-body">

                @if(session('status'))
                    <div class="alert alert-success mb-4">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="correo@ejemplo.com"
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0">Contraseña</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="small text-decoration-none"
                                   style="color:var(--color-primary);">
                                    ¿La olvidaste?
                                </a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Recordarme --}}
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember"
                                   class="form-check-input" id="remember"
                                   style="border-color:var(--color-stone-dark);">
                            <label class="form-check-label small text-muted" for="remember">
                                Mantener sesión iniciada
                            </label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-login w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </button>

                </form>
            </div>
        </div>

        {{-- Footer --}}
        <div class="login-footer">
            <i class="bi bi-shield-check me-1"></i>
            Acceso seguro · Solo usuarios autorizados
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
