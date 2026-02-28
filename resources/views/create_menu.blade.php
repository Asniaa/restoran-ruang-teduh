@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Tambah Menu</h3>
                    <p class="text-muted small">Tambahkan menu baru ke daftar.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('manage.menus.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" required placeholder="Contoh: Nasi Goreng Spesial">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control" min="0" required placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="aktif" value="1" id="statusAktif" checked>
                                <label class="form-check-label" for="statusAktif">Status Aktif</label>
                            </div>
                            <div class="form-text">Menu yang aktif akan ditampilkan di halaman pemesanan.</div>
                        </div>

                        <div class="d-grid gap-2 d-flex justify-content-end">
                            <a href="{{ route('manage.menus.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
