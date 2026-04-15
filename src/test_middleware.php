<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Http\Request;

$admin = App\Models\User::where('email', 'admin@procesos.local')->first();
if (! $admin) { echo "no admin\n"; exit(1); }

// Ensure guard/session
$app['auth']->guard()->setUser($admin);
$session = $app['session']->driver();
$session->start();
$guard = $app['auth']->guard();
$session->put($guard->getName(), $admin->getAuthIdentifier());

$request = Request::create('/internal/procesos','GET');
$request->setLaravelSession($session);

$middleware = new RoleMiddleware();
try {
    $reflection = new ReflectionClass($middleware);
    // Inspect the user the guard returns inside the middleware
    $authUser = $app['auth']->guard()->user();
    echo "Auth guard user class: ".get_class($authUser)."\n";
    echo "Auth guard user email: ".($authUser->email ?? 'null')."\n";
    echo "method_exists hasAnyRole: ".(method_exists($authUser,'hasAnyRole')? 'yes':'no')."\n";
    echo "direct hasAnyRole(['administrador']): ".($authUser->hasAnyRole(['administrador'])? 'true':'false')."\n";

    $res = $middleware->handle($request, function($r){ return 'next-called'; }, 'administrador');
    var_dump($res);
} catch (Exception $e) {
    echo "Exception: ".$e->getMessage()."\n";
    echo get_class($e)."\n";
}

