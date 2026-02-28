<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMejaRequest;
use App\Http\Requests\UpdateMejaRequest;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index()
    {
        $tables = Meja::orderBy('nomor_meja')->paginate(20);
        return view('manage.meja.index', ['tables' => $tables]);
    }

    public function create()
    {
        return view('manage.meja.create');
    }

    public function store(StoreMejaRequest $request)
    {
        Meja::create($request->validated());
        return redirect()->route('manage.meja.index')->with('success', 'Meja created successfully.');
    }

    public function edit($id)
    {
        $table = Meja::findOrFail($id);
        return view('manage.meja.edit', ['table' => $table]);
    }

    public function update(UpdateMejaRequest $request, $id)
    {
        $table = Meja::findOrFail($id);
        $table->update($request->validated());
        return redirect()->route('manage.meja.index')->with('success', 'Meja updated successfully.');
    }

    public function destroy($id)
    {
        $table = Meja::findOrFail($id);
        $table->delete();
        return redirect()->route('manage.meja.index')->with('success', 'Meja deleted successfully.');
    }
}
