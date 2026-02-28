@extends('layouts.app')

@section('title', 'Dashboard Dapur')

@section('content')
    <h2 style="font-size: 1.8rem; font-family: Georgia; margin-bottom: 2rem;">👨‍🍳 Dashboard Dapur</h2>

    <!-- AUTO REFRESH INFO -->
    <div style="background: #E8B84B; color: #2C4A32; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500;">
        ⏱️ Auto refresh setiap 30 detik | Last updated: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
    </div>

    <!-- PESANAN BARU -->
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">🆕 Pesanan Baru <span class="badge badge-danger" style="font-size: 1rem;">{{ $countBaru }}</span></h3>
        @if($countBaru > 0)
            <div style="background: #fff3cd; border-left: 4px solid #E8B84B; padding: 0.8rem; margin-bottom: 1rem; border-radius: 4px;">
                ⚠️ Ada {{ $countBaru }} pesanan baru yang menunggu!
            </div>
        @endif
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($pesananBaru as $p)
                <div style="border: 2px solid #E8B84B; border-radius: 12px; padding: 1.5rem; background: #fffbf0;">
                    <h4 style="margin-bottom: 0.5rem; color: #E8B84B; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">⏰ {{ $p->created_at->format('H:i:s') }} ({{ $p->created_at->diffForHumans() }})</p>
                    <ul style="list-style: none; margin-bottom: 1rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">
                        @foreach($p->detailPesanan as $d)
                            <li style="padding: 0.3rem 0; font-size: 0.95rem;">📍 {{ $d->menu->nama_menu }} <span style="font-weight: bold;">×{{ $d->kuantitas }}</span></li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('dapur.mulaiMasak', $p->id) }}" style="display: inline; width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-warning" style="width: 100%; padding: 0.8rem; font-weight: 600;">▶️ Mulai Memasak</button>
                    </form>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">✅ Tidak ada pesanan baru</div>
            @endforelse
        </div>
    </div>

    <!-- SEDANG DIMASAK -->
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">🍳 Sedang Dimasak <span class="badge badge-info" style="font-size: 1rem;">{{ $countSedangMasak }}</span></h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($pesananSedangMasak as $p)
                <div style="border: 2px solid #3D6B4F; border-radius: 12px; padding: 1.5rem; background: #f9f9f9;">
                    <h4 style="margin-bottom: 0.5rem; color: #3D6B4F; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">⏱️ {{ $p->updated_at->diffForHumans() }}</p>
                    <ul style="list-style: none; margin-bottom: 1rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">
                        @foreach($p->detailPesanan as $d)
                            <li style="padding: 0.3rem 0; font-size: 0.95rem;">🔖 {{ $d->menu->nama_menu }} <span style="font-weight: bold;">×{{ $d->kuantitas }}</span></li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('dapur.tandaiSelesai', $p->id) }}" style="display: inline; width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.8rem; font-weight: 600;">✅ Tandai Selesai</button>
                    </form>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">✓ Tidak ada yang sedang dimasak</div>
            @endforelse
        </div>
    </div>

    <!-- SIAP DIANTAR -->
    <div class="card">
        <h3 style="font-size: 1.3rem; margin-bottom: 1rem;">✅ Siap Diantar <span class="badge badge-success" style="font-size: 1rem;">{{ $countSiapDiantar }}</span></h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($pesananSiapDiantar as $p)
                <div style="border: 2px solid #6B9D7F; border-radius: 12px; padding: 1.5rem; background: #f0f8f4; opacity: 0.9;">
                    <h4 style="margin-bottom: 0.5rem; color: #2C4A32; font-size: 1.2rem;">🪑 Meja {{ $p->meja->nomor_meja }}</h4>
                    <ul style="list-style: none; font-size: 0.95rem;">
                        @foreach($p->detailPesanan as $d)
                            <li style="padding: 0.3rem 0;">✓ {{ $d->menu->nama_menu }} (×{{ $d->kuantitas }})</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: #f0f0f0; border-radius: 8px;">Tidak ada pesanan siap diantar</div>
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

        // Notification jika ada pesanan baru
        const newOrderCount = {{ $countBaru }};
        if (newOrderCount > 0 && 'Notification' in window && Notification.permission === 'granted') {
            new Notification('Ada Pesanan Baru! 🔔', {
                body: `${newOrderCount} pesanan menunggu untuk dimasak`
            });
        }
    </script>
@endsection
