@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Tambah Meja</h3>
                    <p class="text-muted small">Tambahkan meja baru ke restoran.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('manage.meja.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nomor Meja</label>
                            <input type="text" name="nomor_meja" class="form-control" required placeholder="Contoh: T-01">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Status Awal</label>
                            <select name="status" class="form-select" required>
                                <option value="available" selected>Available (Tersedia)</option>
                                <option value="booked">Booked (Dipesan)</option>
                                <option value="occupied">Occupied (Terisi)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-flex justify-content-end">
                            <a href="{{ route('manage.meja.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Meja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
