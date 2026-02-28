@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="mb-1">Checkout</h3>
                    <p class="text-muted small">Lengkapi detail pesanan Anda.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('order.processCheckout') }}">
                        @csrf
                        
                        <!-- Hidden Operational Day -->
                        <input type="hidden" name="operational_day_id" value="{{ $operational_day_id }}">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Pilih Meja</label>
                            <select name="meja_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Meja --</option>
                                @foreach($tables as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->nomor_meja }} ({{ ucfirst($t->status) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Jenis Pesanan</label>
                            <select name="jenis_pesanan" class="form-select" required>
                                <option value="dine_in">Dine In (Makan di Tempat)</option>
                                <option value="take_away">Take Away (Bungkus)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Ditangani Oleh</label>
                            <select name="ditangani_oleh" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Staff --</option>
                                @foreach($staff as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} ({{ ucfirst($s->role) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Metode Pembayaran</label>
                            <div class="d-flex gap-3">
                                <div class="form-check border p-3 rounded flex-fill">
                                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="payCash" value="cash" checked>
                                    <label class="form-check-label w-100 stretched-link" for="payCash">
                                        <i class="bi bi-cash me-2"></i> Cash
                                    </label>
                                </div>
                                <div class="form-check border p-3 rounded flex-fill">
                                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="payQris" value="qris">
                                    <label class="form-check-label w-100 stretched-link" for="payQris">
                                        <i class="bi bi-qr-code me-2"></i> QRIS
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary py-2 fw-bold" type="submit">
                                Bayar & Selesaikan <i class="bi bi-check-circle ms-2"></i>
                            </button>
                            <a class="btn btn-outline-secondary py-2" href="{{ route('order.cart') }}">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
