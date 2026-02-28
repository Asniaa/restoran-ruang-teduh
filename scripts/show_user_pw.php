<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the framework
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

$u = User::first();
if (! $u) {
    echo "NO_USER\n";
    exit(0);
}

echo "email:" . $u->email . PHP_EOL;
$orig = $u->getOriginal('password');
if ($orig === null) {
    echo "stored: (null)\n";
    exit(0);
}

try {
    $dec = Crypt::decryptString($orig);
    echo "decrypted:" . $dec . PHP_EOL;
} catch (\Exception $e) {
    echo "stored-raw:" . $orig . PHP_EOL;
}
