$admin = \App\Models\User::where('email', 'admin@procesos.local')->first();
$agente = \App\Models\User::where('email', 'agente@procesos.local')->first();

echo "Admin user: " . ($admin ? $admin->name : "NOT FOUND") . "\n";
echo "Admin roles: " . ($admin ? $admin->getRoleNames()->implode(', ') : "N/A") . "\n";
echo "Admin permissions count: " . ($admin ? $admin->getAllPermissions()->count() : 0) . "\n\n";

echo "Agente user: " . ($agente ? $agente->name : "NOT FOUND") . "\n";
echo "Agente roles: " . ($agente ? $agente->getRoleNames()->implode(', ') : "N/A") . "\n";
echo "Agente permissions count: " . ($agente ? $agente->getAllPermissions()->count() : 0) . "\n\n";

$procesos = \App\Models\Proceso::count();
$flujos = \DB::table('flujos')->count();
$personas = \App\Models\Persona::count();

echo "Total procesos: " . $procesos . "\n";
echo "Total flujos: " . $flujos . "\n";
echo "Total personas: " . $personas . "\n";
