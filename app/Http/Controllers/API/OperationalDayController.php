<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OperationalDay;
use Illuminate\Http\Request;

class OperationalDayController extends Controller
{
    public function index()
    {
        $operationalDays = OperationalDay::with(['stokMenuHarian.menu'])->get();
        return response()->json([
            'success' => true,
            'data' => $operationalDays
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:open,closed'
        ]);

        $operationalDay = OperationalDay::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Operational day berhasil ditambahkan',
            'data' => $operationalDay
        ], 201);
    }

    public function show($id)
    {
        $operationalDay = OperationalDay::with(['stokMenuHarian.menu'])->find($id);

        if (!$operationalDay) {
            return response()->json([
                'success' => false,
                'message' => 'Operational day tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $operationalDay
        ]);
    }

    public function update(Request $request, $id)
    {
        $operationalDay = OperationalDay::find($id);

        if (!$operationalDay) {
            return response()->json([
                'success' => false,
                'message' => 'Operational day tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'tanggal' => 'sometimes|date',
            'status' => 'sometimes|in:open,closed'
        ]);

        $operationalDay->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Operational day berhasil diupdate',
            'data' => $operationalDay
        ]);
    }

    public function destroy($id)
    {
        $operationalDay = OperationalDay::find($id);

        if (!$operationalDay) {
            return response()->json([
                'success' => false,
                'message' => 'Operational day tidak ditemukan'
            ], 404);
        }

        $operationalDay->delete();

        return response()->json([
            'success' => true,
            'message' => 'Operational day berhasil dihapus'
        ]);
    }
}