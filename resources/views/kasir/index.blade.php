@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
    <h2 style="font-size: 1.8rem; font-family: Georgia; margin-bottom: 2rem;">💰 Dashboard Kasir</h2>

    <!-- AUTO REFRESH INFO -->
    <div style="background: #E8B84B; color: #2C4A32; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500;">
        ⏱️ Auto refresh setiap 30 detik | Last updated: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
    </div>

    <!-- BELUM BAYAR -->
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">📝 Pesanan Menunggu Pembayaran <span class="badge badge-danger" style="font-size: 1rem;">{{ count($pesananBelumBayar) }}</span></h3>
        @if(count($pesananBelumBayar) > 0)
            <div style="background: #fff3cd; border-left: 4px solid #E8B84B; padding: 0.8rem; margin-bottom: 1rem; border-radius: 4px;">
                ⚠️ Ada {{ count($pesananBelumBayar) }} pesanan menunggu pembayaran!
            </div>
        @endif
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
            @forelse($pesananBelumBayar as $p)
                <div style="border: 2px solid #E8B84B; border-radius: 12px; padding: 1.5rem; cursor: pointer; background: #fffbf0; transition: all 0.3s;" 
                     onclick="window.location.href='{{ route('kasir.showPesanan', $p->id) }}'"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'"
                     onmouseout="this.style.boxShadow='none'">
                    <h4 style="margin-bottom: 0.5rem; color: #E8B84B; font-size: 1.3rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">📦 {{ count($p->detailPesanan) }} item</p>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">🕐 {{ $p->updated_at->format('H:i:s') }}</p>
                    <p style="font-size: 1.2rem; font-weight: bold; color: #3D6B4F; text-align: right; padding-top: 0.5rem; border-top: 1px solid #ddd;">
                        Rp {{ number_format((float)$p->detailPesanan->sum(fn($d) => (float)($d->menu->harga ?? 0) * $d->kuantitas), 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">✅ Tidak ada pesanan yang perlu dibayar</div>
            @endforelse
        </div>
    </div>

    <!-- SUDAH BAYAR -->
    <div class="card">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">✅ Sudah Dibayar Hari Ini <span class="badge badge-success" style="font-size: 1rem;">{{ count($pesananSudahBayar) }}</span></h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
            @forelse($pesananSudahBayar as $p)
                <div style="border: 2px solid #6B9D7F; border-radius: 12px; padding: 1.5rem; opacity: 0.9; background: #f0f8f4;">
                    <h4 style="margin-bottom: 0.5rem; color: #2C4A32; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">
                        @if($p->payment)
                            💳 Metode: <strong>{{ strtoupper($p->payment->metode_pembayaran) }}</strong>
                        @else
                            -
                        @endif
                    </p>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">🕐 {{ $p->payment?->waktu_bayar?->format('H:i:s') ?? '-' }}</p>
                    <p style="font-size: 1.1rem; font-weight: bold; color: #3D6B4F; text-align: right; padding-top: 0.5rem; border-top: 1px solid #ddd;">
                        Rp {{ number_format((float)($p->payment->total_bayar ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">Belum ada pembayaran hari ini</div>
            @endforelse
        </div>
    </div>

    <script>
        // Update last update time
        function updateLastUpdate() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('lastUpdate').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update setiap detik
        setInterval(updateLastUpdate, 1000);
    </script>
@endsection
