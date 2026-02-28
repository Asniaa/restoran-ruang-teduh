<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OperationalDay;

class OperationalDayController extends Controller
{
    public function index()
    {
        $days = OperationalDay::orderByDesc('tanggal')->paginate(20);
        return view('manage.operational_days.index', ['days' => $days]);
    }

    public function store()
    {
        // Check if today already exists
        $today = now()->toDateString();
        $exists = OperationalDay::whereDate('tanggal', $today)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Operational Day for today already exists.');
        }

        // Close any other open days (optional, business rule)
        OperationalDay::where('status', 'open')->update(['status' => 'closed']);

        OperationalDay::create([
            'tanggal' => $today,
            'status' => 'open'
        ]);

        return redirect()->route('manage.operational-days.index')->with('success', 'New Operational Day started for today.');
    }

    public function toggle($id)
    {
        $day = OperationalDay::findOrFail($id);
        $day->status = $day->status === 'open' ? 'closed' : 'open';
        $day->save();
        return redirect()->route('manage.operational-days.index')->with('success', 'Operational Day status updated.');
    }
}
