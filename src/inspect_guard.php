<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$guard = Illuminate\Support\Facades\Auth::guard();
$reflect = new ReflectionClass($guard);
$methods = array_map(fn($m)=>$m->name, $reflect->getMethods());
echo json_encode($methods, JSON_PRETTY_PRINT) . PHP_EOL;
if (method_exists($guard, 'getName')) {
    echo "getName: ". $guard->getName() . PHP_EOL;
}
