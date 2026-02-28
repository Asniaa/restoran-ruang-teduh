@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Tambah Karyawan</h3>
                    <p class="text-muted small">Daftarkan karyawan baru.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('manage.karyawan.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Nama Karyawan">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Role / Jabatan</label>
                                <select name="role" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="owner">Owner</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="pelayan">Pelayan</option>
                                    <option value="dapur">Dapur</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Tautkan Akun User</label>
                                <select name="user_id" class="form-select">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->email }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text small">Opsional: Hubungkan dengan akun login.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Status Keaktifan</label>
                            <select name="aktif" class="form-select">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-flex justify-content-end">
                            <a href="{{ route('manage.karyawan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Karyawan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
