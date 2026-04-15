<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

$admin = User::where('email', 'admin@procesos.local')->first();
if (! $admin) {
    echo "Usuario admin@procesos.local no encontrado\n";
    exit(1);
}

auth()->login($admin);
// Ensure the Auth guard has the user instance (Spatie middleware uses Auth::guard()->user())
Auth::setUser($admin);
// Also set the user on the application's auth guard instance
// Also set the user on the application's auth guard instance
$app['auth']->guard()->setUser($admin);

// Prepare a session containing the authenticated user id so the SessionGuard can find the user
$session = $app['session']->driver();
$session->start();
$guard = $app['auth']->guard();
$session->put($guard->getName(), $admin->getAuthIdentifier());

// Session cookie name
$sessionCookieName = Config::get('session.cookie');

$routes = [
    '/internal/procesos',
    '/internal/criticidades',
    '/internal/estados',
    '/internal/personas',
    '/settings/access-control',
];

echo "Probando rutas como: {$admin->email} (Roles: " . $admin->getRoleNames()->implode(', ') . ")\n\n";

foreach ($routes as $uri) {
    // Debug: check role checks directly
    echo "hasAnyRole(['Administrador','administrador','admin']): ".( $admin->hasAnyRole(['Administrador','administrador','admin']) ? 'true' : 'false')."\n";
    echo "getRoleNames: ".json_encode($admin->getRoleNames()->toArray())."\n";
    $request = Request::create($uri, 'GET');
    // Attach the prepared session and session cookie so Laravel's SessionGuard can read the user
    $request->setLaravelSession($session);
    $request->cookies->set($sessionCookieName, $session->getId());
    $request->headers->set('Cookie', $sessionCookieName.'='.$session->getId());
    // Ensure the request resolves the authenticated user as a fallback
    $request->setUserResolver(function () use ($admin) { return $admin; });
    // Use HTTP Kernel to process middleware groups correctly
    // Debug: print guard user before handling
    $current = $app['auth']->guard()->user();
    echo "Guard before handle: ".($current?->email ?? 'null')."\n";
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request);
    $currentAfter = $app['auth']->guard()->user();
    echo "Guard after handle: ".($currentAfter?->email ?? 'null')."\n";
    $status = $response->getStatusCode();
    $length = strlen($response->getContent());
    echo "[{$status}] {$uri} - {$length} bytes\n";
    if ($status !== 200) {
        echo "  --> Resumen: ";
        $content = strip_tags(substr($response->getContent(), 0, 500));
        $content = preg_replace('/\s+/', ' ', $content);
        echo trim($content) . "\n";
    }
}

// Además, intentar la ruta exacta que normalmente da 403 si la conocemos.\n// Puedes indicar otra ruta si quieres probarla específicamente.

echo "\nPruebas completadas.\n";
