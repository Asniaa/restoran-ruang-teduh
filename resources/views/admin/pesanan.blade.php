@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
    <h2 style="font-size: 1.8rem; font-family: Georgia; margin-bottom: 2rem;">📝 Data Pesanan</h2>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>No Pesanan</th>
                    <th>Meja</th>
                    <th>Status</th>
                    <th>Total Item</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                    <tr>
                        <td>#{{ $pesanan->id }}</td>
                        <td>Meja {{ $pesanan->meja->nomor_meja ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background: {{ $pesanan->status === 'open' ? '#6B9D7F' : ($pesanan->status === 'preparing' ? '#E8B84B' : ($pesanan->status === 'ready' ? '#3D6B4F' : '#B85C5C')) }}; padding: 0.3rem 0.6rem; border-radius: 4px; color: white;">
                                {{ ucfirst($pesanan->status) }}
                            </span>
                        </td>
                        <td>{{ $pesanan->detail_pesanan_count ?? 0 }} item</td>
                        <td>{{ $pesanan->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem;">Tidak ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($pesanans->hasPages())
            <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
                {{ $pesanans->links() }}
            </div>
        @endif
    </div>
@endsection
