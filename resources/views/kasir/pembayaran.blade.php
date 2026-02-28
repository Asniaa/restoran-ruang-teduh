@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <h2 style="font-size: 1.8rem; font-family: Georgia; margin-bottom: 2rem;">💳 Pembayaran Meja {{ $pesanan->meja->nomor_meja }}</h2>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <div class="card">
                <h3 style="margin-bottom: 1.5rem;">Detail Pesanan</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->detailPesanan as $d)
                            <tr>
                                <td>{{ $d->menu->nama_menu }}</td>
                                <td>{{ $d->kuantitas }}</td>
                                <td>Rp {{ number_format((float)$d->menu->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float)$d->menu->harga * $d->kuantitas, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="card">
                <h3 style="margin-bottom: 1.5rem;">Proses Pembayaran</h3>
                
                <div style="background: #C5D89D; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; text-align: center;">
                    <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Total Bayar</p>
                    <p style="font-size: 2rem; font-weight: bold; color: #2C4A32;">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>

                <form method="POST" action="{{ route('kasir.prosesPembayaran', $pesanan->id) }}" id="paymentForm">
                    @csrf

                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metodePembayaran" onchange="toggleJumlahBayar()" required>
                            <option value="">-- Pilih --</option>
                            <option value="cash">💵 Cash</option>
                            <option value="qris">📱 QRIS</option>
                        </select>
                    </div>

                    <div class="form-group" id="jumlahBayarGroup" style="display: none;">
                        <label>Jumlah Uang</label>
                        <input type="number" name="jumlah_bayar" id="jumlahBayar" step="1" min="{{ $total }}" onchange="hitungKembalian()" placeholder="Masukkan jumlah uang">
                    </div>

                    <div id="kembalianGroup" style="display: none; background: #d4edda; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Kembalian</p>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #155724;">Rp <span id="kembalianNilai">0</span></p>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Proses Pembayaran</button>
                </form>

                <a href="{{ route('kasir.index') }}" class="btn btn-danger" style="width: 100%; padding: 1rem; text-align: center; margin-top: 1rem;">Batal</a>
            </div>
        </div>
    </div>

    <script>
        function toggleJumlahBayar() {
            const metode = document.getElementById('metodePembayaran').value;
            const jumlahGroup = document.getElementById('jumlahBayarGroup');
            const kembalianGroup = document.getElementById('kembalianGroup');
            const paymentForm = document.getElementById('paymentForm');
            
            if (metode === 'cash') {
                jumlahGroup.style.display = 'block';
                kembalianGroup.style.display = 'block';
                document.getElementById('jumlahBayar').required = true;
                document.getElementById('jumlahBayar').value = {{ $total }};
                hitungKembalian();
            } else if (metode === 'qris') {
                jumlahGroup.style.display = 'none';
                kembalianGroup.style.display = 'none';
                document.getElementById('jumlahBayar').required = false;
                document.getElementById('jumlahBayar').value = {{ $total }};
            }
        }

        function hitungKembalian() {
            const jumlahBayar = parseFloat(document.getElementById('jumlahBayar').value) || 0;
            const total = {{ $total }};
            const kembalian = jumlahBayar - total;
            
            if (kembalian >= 0) {
                document.getElementById('kembalianNilai').textContent = new Intl.NumberFormat('id-ID').format(Math.floor(kembalian));
            } else {
                document.getElementById('kembalianNilai').textContent = '0 (Uang kurang)';
                document.getElementById('kembalianNilai').style.color = '#B85C5C';
            }
        }

        // Set minimum jumlah bayar
        document.getElementById('jumlahBayar').addEventListener('change', function() {
            const total = {{ $total }};
            const value = parseFloat(this.value) || 0;
            if (value < total) {
                this.value = total;
                alert('Jumlah pembayaran tidak boleh kurang dari total');
                hitungKembalian();
            }
        });
    </script>
@endsection
