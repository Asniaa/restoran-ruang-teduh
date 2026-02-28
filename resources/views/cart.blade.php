@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Keranjang Belanja</h2>
            <p class="text-muted">Periksa kembali pesanan Anda sebelum checkout.</p>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('order.index') }}">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Menu</th>
                        <th>Harga</th>
                        <th class="text-center">Qty</th>
                        <th>Subtotal</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $it)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $it['nama_menu'] }}</td>
                        <td>Rp {{ number_format($it['harga'], 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $it['qty'] }}</span>
                        </td>
                        <td class="fw-bold text-primary">Rp {{ number_format($it['subtotal'], 0, ',', '.') }}</td>
                        <td class="text-end pe-4">
                            <form method="post" action="{{ route('order.remove', ['menuId' => $it['id']]) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" type="submit" title="Hapus Item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-basket display-1 mb-3 d-block text-secondary opacity-25"></i>
                            <p>Keranjang Anda masih kosong.</p>
                            <a href="{{ route('order.index') }}" class="btn btn-primary mt-2">Mulai Pesan</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
                @if(count($items) > 0)
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold py-3">Total Pembayaran</td>
                        <td colspan="2" class="fw-bold text-primary fs-5 py-3 ps-3">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    @if(count($items) > 0)
    <div class="d-flex justify-content-end gap-2">
        <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="btn btn-primary px-4" href="{{ route('order.checkout') }}">
            Checkout <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
    @endif
@endsection
