<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | <?php echo e(config('app.name')); ?></title>
    
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/css/bootstrap.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/adminlte.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    
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
            
            <div class="login-header">
                <i class="fas fa-cubes" style="font-size: 40px; margin-bottom: 10px;"></i>
                <h1><?php echo e(config('app.name')); ?></h1>
                <p>Sistema de Procesos Institucionales</p>
            </div>
            
            
            <div class="login-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <?php if($errors->has('auth')): ?>
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($errors->first('auth')); ?>

                        <?php else: ?>
                            <i class="fas fa-exclamation-circle"></i>
                            Por favor verifica los errores abajo
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <i class="fas fa-check-circle"></i>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                
                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('email')); ?>"
                               placeholder="user@example.com"
                               required 
                               autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-text"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    
                    <?php if(! env('LOGIN_NO_PASSWORD', true)): ?>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="••••••••"
                                   required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error-text"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info small">Autenticación en modo desarrollo: sólo ingresa el email para iniciar sesión.</div>
                    <?php endif; ?>
                    
                    
                    <div class="form-check">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="form-check-input"
                               <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="remember">
                            Recuérdame
                        </label>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-login mt-4">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar Sesión
                    </button>
                </form>
                
                
                <?php
                    $adminUser = \App\Models\User::role('Administrador')->first();
                    $agentUser = \App\Models\User::role('Agente')->first();
                    $testPassword = env('TEST_USER_PASSWORD', 'password');
                ?>

                <div class="credentials-hint">
                    <h5><i class="fas fa-info-circle mr-2"></i>Credenciales de Prueba</h5>
                    <p><strong>Administrador:</strong></p>
                    <p>Email: <code><?php echo e($adminUser ? $adminUser->email : 'admin@prueba.local'); ?></code></p>
                    <p>Contraseña: <code><?php echo e($testPassword); ?></code></p>

                    <hr class="my-2">

                    <p><strong>Agente:</strong></p>
                    <p>Email: <code><?php echo e($agentUser ? $agentUser->email : 'agente@prueba.local'); ?></code></p>
                    <p>Contraseña: <code><?php echo e($testPassword); ?></code></p>
                </div>
            </div>
        </div>
    </div>
    
    
    <script src="<?php echo e(asset('plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
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
<?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>