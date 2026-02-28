@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1">Resto App</h3>
                    <p class="text-muted small mb-0">Jl. Contoh Restoran No. 123</p>
                    <p class="text-muted small">Telp: 0812-3456-7890</p>
                </div>
                
                <div class="border-top border-bottom py-3 mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">ID Pesanan</span>
                        <span class="fw-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Tanggal</span>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($order->waktu_pesan)->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Meja</span>
                        <span class="fw-medium">{{ $order->meja?->nomor_meja ?? 'Take Away' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Kasir</span>
                        <span class="fw-medium">{{ $order->karyawan?->nama ?? '-' }}</span>
                    </div>
                </div>
                
                <table class="table table-borderless table-sm mb-3">
                    <thead class="border-bottom">
                        <tr>
                            <th class="ps-0">Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end pe-0">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $it)
                        <tr>
                            <td class="ps-0">
                                <div class="fw-medium">{{ $it['menu'] }}</div>
                            </td>
                            <td class="text-center">{{ $it['qty'] }}</td>
                            <td class="text-end pe-0">
                                <div>Rp {{ number_format($it['subtotal'], 0, ',', '.') }}</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="border-top">
                        <tr>
                            <td colspan="2" class="ps-0 fw-bold pt-3">Total</td>
                            <td class="text-end pe-0 fw-bold pt-3 fs-5">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="ps-0 text-muted small">Metode Pembayaran</td>
                            <td class="text-end pe-0 fw-medium small text-uppercase">{{ $order->payment?->metode_pembayaran ?? '-' }}</td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="text-center mt-4 mb-4">
                    <p class="small text-muted mb-0">Terima kasih atas kunjungan Anda!</p>
                    <p class="small text-muted">Silakan datang kembali.</p>
                </div>
                
                <div class="d-grid gap-2 d-print-none">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i> Cetak Struk
                    </button>
                    <a href="{{ route('order.index') }}" class="btn btn-outline-secondary">
                        Buat Pesanan Baru
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none text-muted">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .card, .card * {
        visibility: visible;
    }
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
    .d-print-none {
        display: none !important;
    }
}
</style>
@endsection
