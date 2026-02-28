@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Pesan Menu</h2>
            <p class="text-muted">Pilih menu favoritmu untuk dipesan.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a class="btn btn-primary position-relative" href="{{ route('order.cart') }}">
                <i class="bi bi-cart3 me-1"></i> Keranjang
                @if(session('cart'))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count(session('cart')) }}
                        <span class="visually-hidden">items in cart</span>
                    </span>
                @endif
            </a>
        </div>
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
                        
                        <form class="mt-auto" method="post" action="{{ route('order.add') }}">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $m->id }}">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-dash-lg" style="font-size: 0.8rem;"></i></span>
                                <input type="number" name="qty" value="1" min="1" class="form-control text-center border-start-0 border-end-0" style="max-width: 60px;">
                                <span class="input-group-text bg-white border-start-0"><i class="bi bi-plus-lg" style="font-size: 0.8rem;"></i></span>
                                <button class="btn btn-primary ms-2 rounded-end" type="submit">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
