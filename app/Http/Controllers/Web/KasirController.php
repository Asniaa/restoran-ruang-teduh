<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Payment;
use App\Models\Meja;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Dashboard kasir dengan pesanan yang sudah diantar
     */
    public function index()
    {
        $today = now()->toDateString();

        // Pesanan SUDAH DIANTAR yang belum bayar (status=delivered)
        $pesananBelumBayar = Pesanan::where('status', 'delivered')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Pesanan SUDAH BAYAR (status=paid)
        $pesananSudahBayar = Pesanan::where('status', 'paid')
            ->whereDate('created_at', $today)
            ->with(['meja', 'payment'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('kasir.index', [
            'pesananBelumBayar' => $pesananBelumBayar,
            'pesananSudahBayar' => $pesananSudahBayar,
        ]);
    }

    /**
     * Tampil detail pesanan untuk pembayaran
     */
    public function showPesanan($id)
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu'])->findOrFail($id);

        // Hitung total
        $total = 0;
        foreach ($pesanan->detailPesanan as $detail) {
            $total += $detail->menu->harga * $detail->kuantitas;
        }

        return view('kasir.pembayaran', [
            'pesanan' => $pesanan,
            'total' => $total,
        ]);
    }

    /**
     * Proses pembayaran
     */
    public function prosesPembayaran(Request $request, $id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);

        // Hitung total
        $total = 0;
        foreach ($pesanan->detailPesanan as $detail) {
            $total += $detail->menu->harga * $detail->kuantitas;
        }

        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:cash,qris',
            'jumlah_bayar' => 'required|numeric|min:' . $total,
        ]);

        $kembalian = 0;
        if ($validated['metode_pembayaran'] === 'cash') {
            $kembalian = $validated['jumlah_bayar'] - $total;
        }

        // Create payment record
        // Pastikan user kasir memiliki data karyawan terkait
        $karyawanId = auth()->user()->karyawan?->id; 
        
        if (!$karyawanId) {
             // Fallback jika data karyawan belum ada (misal admin yang login sebagai kasir tapi belum dibuatkan data karyawan)
             // Sebaiknya handle error atau gunakan ID dummy/admin.
             // Untuk sementara kita gunakan user_id jika struktur DB mengizinkan, tapi foreign key ke karyawan mengharuskan ID valid dari tabel karyawan.
             // Kita coba cari karyawan berdasarkan user_id manual jika relasi gagal diload (jarang terjadi)
             $karyawan = Karyawan::where('user_id', auth()->id())->first();
             $karyawanId = $karyawan?->id;

             if (!$karyawanId) {
                 return back()->with('error', 'Akun Anda tidak terhubung dengan data karyawan. Hubungi admin.');
             }
        }

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'karyawan_id' => $karyawanId,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'total_bayar' => $total,
            'jumlah_bayar' => $validated['jumlah_bayar'],
            'kembalian' => $kembalian,
            'waktu_bayar' => now(),
        ]);

        // Update pesanan status jadi paid
        $pesanan->update(['status' => 'paid']);

        // Update meja status jadi available
        Meja::find($pesanan->meja_id)->update(['status' => 'available']);

        return redirect()->route('kasir.index')
            ->with('success', 'Pembayaran pesanan meja ' . $pesanan->meja->nomor_meja . ' berhasil diproses.');
    }
}
