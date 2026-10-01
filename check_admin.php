<?php
// Quick logout test script
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->boot();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== LGU Admin Account Check ===" . PHP_EOL;

$user = User::where('email', 'admin@gubat.gov.ph')->first();

if (!$user) {
    echo "ERROR: User not found!" . PHP_EOL;
    exit(1);
}

echo "Name:      " . $user->name . PHP_EOL;
echo "Email:     " . $user->email . PHP_EOL;
echo "Role:      " . $user->role . PHP_EOL;
echo "Is Active: " . ($user->is_active ? 'true' : 'false') . PHP_EOL;
echo "isLguAdmin(): " . ($user->isLguAdmin() ? 'true' : 'false') . PHP_EOL;
echo PHP_EOL;

echo "=== Route Check ===" . PHP_EOL;
$router = $app->make('router');
$routes = ['logout', 'login', 'admin.dashboard', 'admin.resort-admins.index'];
foreach ($routes as $route) {
    $exists = $router->has($route);
    echo "  route('{$route}'): " . ($exists ? route($route) : 'MISSING') . PHP_EOL;
}

echo PHP_EOL;
echo "=== Password Check ===" . PHP_EOL;
echo "Password 'password' matches: " . (Hash::check('password', $user->password) ? 'YES' : 'NO') . PHP_EOL;
