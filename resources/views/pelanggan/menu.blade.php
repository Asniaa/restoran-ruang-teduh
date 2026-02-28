@extends('layouts.pelanggan')

@section('title', 'Menu - Meja ' . $meja_id)

@section('content')
    @if($isClosed)
        <div
            style="background: #f8e8e8; border: 2px dashed #b85c5c; padding: 3rem 2rem; border-radius: 12px; text-align: center; margin-top: 2rem;">
            <p style="font-size: 3rem; margin-bottom: 1rem;">🔒</p>
            <h2 style="color: #b85c5c; font-family: Georgia; margin-bottom: 1rem;">Mohon Maaf, Restoran Sedang Tutup</h2>
            <p style="color: #666; max-width: 400px; margin: 0 auto;">Kami tidak menerima pemesanan saat ini. Silakan hubungi
                staf kami atau kembali lagi nanti. Terima kasih!</p>
        </div>
    @else
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">🍽️ Daftar Menu</h2>

        <!-- Filter Kategori -->
        <div class="filter-buttons">
            <button class="filter-btn active" onclick="filterMenu('semua')">Semua</button>
            @foreach($kategoris as $kat)
                <button class="filter-btn" onclick="filterMenu({{ $kat->id }})">{{ $kat->nama_kategori }}</button>
            @endforeach
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid">
            @forelse($menus as $menu)
                <div class="menu-card" data-kategori="{{ $menu->kategori_id }}">
                    @if($menu->foto)
                        <div class="menu-image">
                            @if(filter_var($menu->foto, FILTER_VALIDATE_URL))
                                <img src="{{ $menu->foto }}" alt="{{ $menu->nama_menu }}"
                                    style="width: 100%; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}"
                                    style="width: 100%; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                    @else
                        <div class="menu-image"
                            style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 150px;">
                            <span style="color: #ccc;">📸 No Image</span>
                        </div>
                    @endif
                    <div class="menu-header">
                        <h3>{{ $menu->nama_menu }}</h3>
                    </div>
                    <div class="menu-body">
                        <p>Kategori: {{ $menu->kategori->nama_kategori }}</p>
                        <div class="menu-price">Rp {{ number_format((float) $menu->harga, 0, ',', '.') }}</div>
                        <div class="menu-actions">
                            <input type="number" value="1" min="1" class="qty-input" id="qty-{{ $menu->id }}">
                            <button class="btn btn-primary" onclick="addToCart({{ $menu->id }})">+ Pesan</button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">Tidak ada menu tersedia</div>
            @endforelse
        </div>
    @endif
@endsection

@section('cart')
    @if(!$isClosed && $cartItems && count($cartItems) > 0)
        @foreach($cartItems as $item)
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">{{ $item['nama'] }}</div>
                    <div class="cart-item-qty">{{ $item['kuantitas'] }}x Rp {{ number_format((float) $item['harga'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="cart-item-price">Rp {{ number_format((float) $item['subtotal'], 0, ',', '.') }}</div>
            </div>
        @endforeach
        <div class="cart-total">
            Total: Rp {{ number_format((float) $totalHarga, 0, ',', '.') }}
        </div>
    @else
        <p style="text-align: center; padding: 1rem; color: #999;">Belum ada pesanan</p>
    @endif
@endsection

@section('scripts')
    <script>
        function addToCart(menuId) {
            const qty = document.getElementById('qty-' + menuId).value;

            fetch('/meja/{{ $meja_id }}/pesan', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    kuantitas: parseInt(qty)
                })
            })
                .then(r => r.json())
                .then(d => {
                    alert(d.message || 'Menu ditambahkan!');
                    location.reload();
                })
                .catch(e => alert('Error: ' + e));
        }

        function filterMenu(kategoriId) {
            const cards = document.querySelectorAll('.menu-card');

            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Filter cards
            cards.forEach(card => {
                if (kategoriId === 'semua' || card.dataset.kategori == kategoriId) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection