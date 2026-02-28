<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OperationalDay;
use App\Models\Payment;
use App\Models\DetailPesanan;
use App\Models\Pesanan;

class ReportController extends Controller
{
    public function daily($operationalDayId = null)
    {
        if ($operationalDayId === null) {
            $day = OperationalDay::orderByDesc('tanggal')->first();
        } else {
            $day = OperationalDay::findOrFail($operationalDayId);
        }
        if (!$day) {
            return view('manage.reports.daily', [
                'summary' => null,
                'items' => [],
                'day' => null
            ]);
        }

        $payments = Payment::whereHas('pesanan', function ($q) use ($day) {
            $q->where('operational_day_id', $day->id);
        })->get();

        $total = $payments->sum('total_bayar');
        $methodBreakdown = [
            'cash' => $payments->where('metode_pembayaran', 'cash')->sum('total_bayar'),
            'qris' => $payments->where('metode_pembayaran', 'qris')->sum('total_bayar'),
        ];

        $details = DetailPesanan::whereHas('pesanan', function ($q) use ($day) {
            $q->where('operational_day_id', $day->id);
        })->with('menu')->get();

        $items = [];
        foreach ($details as $d) {
            $key = $d->menu_id;
            if (!isset($items[$key])) {
                $items[$key] = [
                    'menu' => $d->menu?->nama_menu ?? 'Menu',
                    'qty' => 0,
                    'revenue' => 0,
                ];
            }
            $qty = $d->qty ?? ($d->jumlah ?? 0);
            $price = $d->harga_saat_pesan ?? ($d->harga_satuan ?? 0);
            $items[$key]['qty'] += $qty;
            $items[$key]['revenue'] += $qty * $price;
        }
        usort($items, function ($a, $b) {
            return $b['revenue'] <=> $a['revenue'];
        });

        $summary = [
            'orders' => Pesanan::where('operational_day_id', $day->id)->count(),
            'payments' => $payments->count(),
            'total' => $total,
            'methods' => $methodBreakdown,
        ];

        return view('manage.reports.daily', [
            'summary' => $summary,
            'items' => $items,
            'day' => $day
        ]);
    }

    public function range()
    {
        $from = request('from');
        $to = request('to');
        if (!$from || !$to) {
            $to = now()->format('Y-m-d');
            $from = now()->subDays(6)->format('Y-m-d');
        }
        $days = OperationalDay::whereBetween('tanggal', [$from, $to])->orderBy('tanggal')->get();
        $rows = [];
        foreach ($days as $day) {
            $payments = Payment::whereHas('pesanan', function ($q) use ($day) {
                $q->where('operational_day_id', $day->id);
            })->get();
            $rows[] = [
                'tanggal' => $day->tanggal,
                'orders' => Pesanan::where('operational_day_id', $day->id)->count(),
                'payments' => $payments->count(),
                'total' => $payments->sum('total_bayar'),
                'cash' => $payments->where('metode_pembayaran', 'cash')->sum('total_bayar'),
                'qris' => $payments->where('metode_pembayaran', 'qris')->sum('total_bayar'),
            ];
        }
        return view('manage.reports.range', ['rows' => $rows]);
    }
}
