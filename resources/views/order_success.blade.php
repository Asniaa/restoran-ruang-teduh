@extends('layouts.app')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <div class="mb-4 text-success">
                        <i class="bi bi-check-circle-fill display-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Pesanan Berhasil!</h2>
                    <p class="text-muted mb-4">Pesanan Anda telah berhasil dibuat dan pembayaran sudah tercatat di sistem.</p>
                    
                    <div class="d-grid gap-3 col-md-8 mx-auto">
                        @if(session('last_pesanan_id'))
                            <a class="btn btn-outline-primary fw-bold" href="{{ route('order.receipt', session('last_pesanan_id')) }}" target="_blank">
                                <i class="bi bi-printer me-2"></i> Cetak Struk
                            </a>
                        @endif
                        
                        <a class="btn btn-primary fw-bold" href="{{ route('order.index') }}">
                            <i class="bi bi-plus-circle me-2"></i> Buat Pesanan Baru
                        </a>
                        
                        <a class="btn btn-link text-decoration-none text-muted" href="{{ route('dashboard') }}">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
