@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Edit Menu</h3>
                    <p class="text-muted small">Perbarui informasi menu.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('manage.menus.update', $menu->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ $menu->kategori_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control" min="0" value="{{ $menu->harga }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="aktif" value="1" id="statusAktif" {{ $menu->aktif ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusAktif">Status Aktif</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-flex justify-content-end">
                            <a href="{{ route('manage.menus.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
