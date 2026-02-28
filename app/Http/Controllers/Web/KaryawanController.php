<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\Karyawan;
use App\Models\User;

class KaryawanController extends Controller
{
    public function index()
    {
        $staff = Karyawan::with('user')->orderBy('nama')->paginate(20);
        return view('manage.karyawan.index', ['staff' => $staff]);
    }

    public function create()
    {
        // Get users who are not yet assigned to a Karyawan
        $assignedUserIds = Karyawan::whereNotNull('user_id')->pluck('user_id');
        $users = User::whereNotIn('id', $assignedUserIds)->orderBy('email')->get();
        return view('manage.karyawan.create', ['users' => $users]);
    }

    public function store(StoreKaryawanRequest $request)
    {
        $data = $request->validated();
        $data['aktif'] = $request->has('aktif');
        Karyawan::create($data);
        return redirect()->route('manage.karyawan.index')->with('success', 'Karyawan created successfully.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        // Get available users plus the current one
        $assignedUserIds = Karyawan::whereNotNull('user_id')->where('id', '!=', $id)->pluck('user_id');
        $users = User::whereNotIn('id', $assignedUserIds)->orderBy('email')->get();

        return view('manage.karyawan.edit', ['karyawan' => $karyawan, 'users' => $users]);
    }

    public function update(UpdateKaryawanRequest $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $data = $request->validated();
        $data['aktif'] = $request->has('aktif');

        $karyawan->update($data);
        return redirect()->route('manage.karyawan.index')->with('success', 'Karyawan updated successfully.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('manage.karyawan.index')->with('success', 'Karyawan deleted successfully.');
    }
}
