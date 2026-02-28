@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Edit Karyawan</h3>
                    <p class="text-muted small">Perbarui data karyawan.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('manage.karyawan.update', $karyawan->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Role / Jabatan</label>
                                <select name="role" class="form-select" required>
                                    <option value="owner" {{ $karyawan->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                    <option value="kasir" {{ $karyawan->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                    <option value="pelayan" {{ $karyawan->role === 'pelayan' ? 'selected' : '' }}>Pelayan</option>
                                    <option value="dapur" {{ $karyawan->role === 'dapur' ? 'selected' : '' }}>Dapur</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Tautkan Akun User</label>
                                <select name="user_id" class="form-select">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ $karyawan->user_id == $u->id ? 'selected' : '' }}>
                                            {{ $u->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Status Keaktifan</label>
                            <select name="aktif" class="form-select">
                                <option value="1" {{ $karyawan->aktif ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$karyawan->aktif ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-flex justify-content-end">
                            <a href="{{ route('manage.karyawan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
