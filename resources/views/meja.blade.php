@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Daftar Meja</h2>
            <p class="text-muted">Informasi ketersediaan meja restoran.</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <div class="row g-4">
        @foreach($tables as $t)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card h-100 border-0 shadow-sm text-center 
                    {{ $t->status == 'available' ? 'bg-success bg-opacity-10' : ($t->status == 'occupied' ? 'bg-danger bg-opacity-10' : 'bg-secondary bg-opacity-10') }}">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center py-4">
                        <i class="bi bi-display fs-1 mb-2 
                           {{ $t->status == 'available' ? 'text-success' : ($t->status == 'occupied' ? 'text-danger' : 'text-secondary') }}"></i>
                        <h5 class="fw-bold mb-1">{{ $t->nomor_meja }}</h5>
                        <span class="badge rounded-pill 
                              {{ $t->status == 'available' ? 'bg-success' : ($t->status == 'occupied' ? 'bg-danger' : 'bg-secondary') }}">
                            {{ ucfirst($t->status) }}
                        </span>
                        @if($t->kapasitas)
                            <small class="text-muted mt-2">{{ $t->kapasitas }} Kursi</small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
