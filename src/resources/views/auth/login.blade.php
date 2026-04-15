<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ config('app.name') }}</title>
    
    {{-- Google Font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    {{-- AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        body.login-page {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-box {
            width: 360px;
            margin: 7% auto;
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .form-check {
            margin-top: 15px;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 3px;
            cursor: pointer;
        }
        
        .form-check-label {
            margin-left: 8px;
            cursor: pointer;
            font-size: 14px;
            user-select: none;
        }
        
        .alert {
            border-radius: 5px;
            border: none;
        }
        
        .credentials-hint {
            background: #f0f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
        }
        
        .credentials-hint h5 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .credentials-hint p {
            margin: 5px 0;
            color: #555;
        }
        
        .credentials-hint code {
            background: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #764ba2;
        }
        
        .error-text {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-card">
            {{-- Header --}}
            <div class="login-header">
                <i class="fas fa-cubes" style="font-size: 40px; margin-bottom: 10px;"></i>
                <h1>{{ config('app.name') }}</h1>
                <p>Sistema de Procesos Institucionales</p>
            </div>
            
            {{-- Body --}}
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        @if ($errors->has('auth'))
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('auth') }}
                        @else
                            <i class="fas fa-exclamation-circle"></i>
                            Por favor verifica los errores abajo
                        @endif
                    </div>
                @endif
                
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="user@example.com"
                               required 
                               autofocus>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- Password (bypassed in this environment) --}}
                    @if(! env('LOGIN_NO_PASSWORD', true))
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="alert alert-info small">Autenticación en modo desarrollo: sólo ingresa el email para iniciar sesión.</div>
                    @endif
                    
                    {{-- Remember Me --}}
                    <div class="form-check">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="form-check-input"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Recuérdame
                        </label>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-login mt-4">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar Sesión
                    </button>
                </form>
                
                {{-- Test Credentials (dynamic from seeder) --}}
                @php
                    $adminUser = \App\Models\User::role('Administrador')->first();
                    $agentUser = \App\Models\User::role('Agente')->first();
                    $testPassword = env('TEST_USER_PASSWORD', 'password');
                @endphp

                <div class="credentials-hint">
                    <h5><i class="fas fa-info-circle mr-2"></i>Credenciales de Prueba</h5>
                    <p><strong>Administrador:</strong></p>
                    <p>Email: <code>{{ $adminUser ? $adminUser->email : 'admin@prueba.local' }}</code></p>
                    <p>Contraseña: <code>{{ $testPassword }}</code></p>

                    <hr class="my-2">

                    <p><strong>Agente:</strong></p>
                    <p>Email: <code>{{ $agentUser ? $agentUser->email : 'agente@prueba.local' }}</code></p>
                    <p>Contraseña: <code>{{ $testPassword }}</code></p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Scripts --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
</body>
</html>
