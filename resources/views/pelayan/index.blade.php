@extends('layouts.app')

@section('title', 'Dashboard Pelayan')

@section('content')
    <h2 style="font-size: 1.8rem; font-family: Georgia; margin-bottom: 2rem;">🚶 Dashboard Pelayan</h2>

    <!-- AUTO REFRESH INFO -->
    <div style="background: #E8B84B; color: #2C4A32; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500;">
        ⏱️ Auto refresh setiap 30 detik | Last updated: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
    </div>

    <!-- PERLU DIANTAR -->
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">📦 Perlu Diantar <span class="badge badge-danger" style="font-size: 1rem;">{{ $countPerluDiantar }}</span></h3>
        @if($countPerluDiantar > 0)
            <div style="background: #fff3cd; border-left: 4px solid #E8B84B; padding: 0.8rem; margin-bottom: 1rem; border-radius: 4px;">
                ⚠️ Ada {{ $countPerluDiantar }} pesanan siap diantar!
            </div>
        @endif
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($pesananPerluDiantar as $p)
                <div style="border: 2px solid #E8B84B; border-radius: 12px; padding: 1.5rem; background: #fffbf0;">
                    <h4 style="margin-bottom: 0.5rem; color: #E8B84B; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">⏰ Siap: {{ $p->updated_at->format('H:i:s') }}</p>
                    <ul style="list-style: none; margin-bottom: 1rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">
                        @foreach($p->detailPesanan as $d)
                            <li style="padding: 0.3rem 0; font-size: 0.95rem;">✓ {{ $d->menu->nama_menu }} <span style="font-weight: bold;">×{{ $d->kuantitas }}</span></li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('pelayan.sudahDiantar', $p->id) }}" style="display: inline; width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.8rem; font-weight: 600;">✅ Sudah Diantar</button>
                    </form>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">✓ Semua pesanan sudah diantar</div>
            @endforelse
        </div>
    </div>

    <!-- SUDAH DIANTAR -->
    <div class="card">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">✅ Sudah Diantar (Riwayat Hari Ini) <span class="badge badge-success" style="font-size: 1rem;">{{ $countSudahDiantar }}</span></h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($pesananSudahDiantar as $p)
                <div style="border: 2px solid #6B9D7F; border-radius: 12px; padding: 1.5rem; background: #f0f8f4; opacity: 0.8;">
                    <h4 style="margin-bottom: 0.5rem; color: #2C4A32; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">🕐 {{ $p->updated_at->format('H:i:s') }}</p>
                    <ul style="list-style: none; font-size: 0.95rem;">
                        @foreach($p->detailPesanan as $d)
                            <li style="padding: 0.3rem 0;">{{ $d->menu->nama_menu }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">Belum ada pesanan yang sudah diantar</div>
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

        // Notification jika ada pesanan baru siap diantar
        const newOrderCount = {{ $countPerluDiantar }};
        if (newOrderCount > 0 && 'Notification' in window && Notification.permission === 'granted') {
            new Notification('Ada Pesanan Siap Diantar! 📦', {
                body: `${newOrderCount} pesanan menunggu untuk diantar`
            });
        }
    </script>
@endsection
