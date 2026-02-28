@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Daftar Menu</h2>
            <p class="text-muted">Jelajahi berbagai menu lezat kami.</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <div class="mb-4 d-flex flex-wrap gap-2">
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2 rounded-pill">All</span>
        @foreach($categories as $cat)
            <span class="badge bg-white text-secondary border px-3 py-2 rounded-pill">{{ $cat->nama_kategori }}</span>
        @endforeach
    </div>

    <div class="row g-4">
        @foreach($menus as $m)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-light text-muted border">{{ $m->kategori ? $m->kategori->nama_kategori : 'Umum' }}</span>
                            <div class="fw-bold text-primary">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                        </div>
                        <h5 class="card-title mb-1">{{ $m->nama_menu }}</h5>
                        <p class="card-text text-muted small mb-3 flex-grow-1">Menu lezat pilihan terbaik untuk Anda.</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
