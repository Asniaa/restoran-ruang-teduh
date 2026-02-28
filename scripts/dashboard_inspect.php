<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pesanan;
use App\Models\Meja;

echo "Pesanan status counts:\n";
$statuses = Pesanan::select('status', \DB::raw('count(*) as cnt'))->groupBy('status')->get();
foreach ($statuses as $s) {
    echo "- {$s->status}: {$s->cnt}\n";
}

$today = now()->toDateString();
$todayCount = Pesanan::whereDate('created_at', $today)->count();
echo "Total pesanan today: {$todayCount}\n";

// Show counts for statuses used by dashboard
$activeCount = Pesanan::whereIn('status', ['open','preparing','ready'])->whereDate('created_at', $today)->count();
echo "Pesanan matching ['open','preparing','ready'] today: {$activeCount}\n";

// Compute using new controller logic (treat non-final as active)
$finalStatuses = ['paid', 'dibayar', 'selesai', 'completed', 'cancelled'];
$pesananAktifNew = Pesanan::whereDate('created_at', $today)->whereNotIn('status', $finalStatuses)->count();
echo "Pesanan aktif (not in final statuses) today: {$pesananAktifNew}\n";

$mejaHuniNew = Pesanan::whereDate('created_at', $today)->whereNotIn('status', $finalStatuses)->whereNotNull('meja_id')->distinct('meja_id')->count('meja_id');
echo "Meja huni (distinct meja_id with non-final orders) today: {$mejaHuniNew}\n";

// Meja huni using 2-hour window (matches controller logic)
$since = now()->subHours(2);
$mejaHuniWindow = Pesanan::where('created_at', '>=', $since)->whereNotIn('status', $finalStatuses)->whereNotNull('meja_id')->distinct('meja_id')->count('meja_id');
echo "Meja huni (non-final orders in last 2 hours): {$mejaHuniWindow}\n";

$occupiedByFlag = Meja::where('status', 'occupied')->pluck('id')->toArray();
$occupiedByOrders = Pesanan::where('created_at', '>=', $since)->whereNotIn('status', $finalStatuses)->whereNotNull('meja_id')->pluck('meja_id')->unique()->filter()->toArray();
$union = array_unique(array_merge($occupiedByFlag, $occupiedByOrders));
echo "Meja huni (hybrid union of flag + recent orders): " . count($union) . "\n";

echo "\nMeja status counts:\n";
$mejaStatuses = Meja::select('status', \DB::raw('count(*) as cnt'))->groupBy('status')->get();
foreach ($mejaStatuses as $m) {
    echo "- {$m->status}: {$m->cnt}\n";
}

$occupied = Meja::where('status', 'occupied')->count();
echo "Meja occupied count (occupied): {$occupied}\n";

// Also show any meja with other status values
$otherMeja = Meja::whereNotIn('status', ['available','occupied','reserved'])->count();
echo "Meja with other statuses: {$otherMeja}\n";
