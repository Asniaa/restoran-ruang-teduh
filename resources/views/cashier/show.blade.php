@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <a href="{{ route('kasir.index') }}"
            class="text-gray-600 hover:text-gray-800 font-medium mb-6 inline-block">&larr; Back to Dashboard</a>

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Order Details #{{ $order->id }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                <p class="mb-2"><span class="font-semibold">Table:</span> {{ $order->meja->nomor_meja }}</p>
                <p class="mb-4"><span class="font-semibold">Date:</span> {{ $order->waktu_pesan->format('d M Y, H:i') }}</p>

                <table class="w-full text-left mb-4">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Item</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Price</th>
                            <th class="py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->detailPesanan as $detail)
                            <tr class="border-b border-gray-100 last:border-0">
                                <td class="py-2">{{ $detail->menu->nama_menu }}</td>
                                <td class="py-2 text-center">{{ $detail->kuantitas }}</td>
                                <td class="py-2 text-right">{{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</td>
                                <td class="py-2 text-right">
                                    {{ number_format($detail->harga_saat_pesan * $detail->kuantitas, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-200">
                            <td colspan="3" class="py-4 text-right font-bold text-lg">Total Amount</td>
                            <td class="py-4 text-right font-bold text-lg text-primary">Rp
                                {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Payment</h2>
                <form action="{{ route('kasir.prosesPembayaran', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Payment Method</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="cash" class="peer sr-only" checked>
                                <div
                                    class="p-4 rounded-xl border-2 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center hover:bg-gray-50">
                                    <span class="font-bold text-gray-800">CASH</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="qris" class="peer sr-only">
                                <div
                                    class="p-4 rounded-xl border-2 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center hover:bg-gray-50">
                                    <span class="font-bold text-gray-800">QRIS</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Cash Input for Change Calculation (Frontend only for now) --}}
                    <div class="mb-6" x-data="{ cash: 0, total: {{ $total }} }">
                        <label class="block text-gray-700 font-bold mb-2">Cash Received (Optional)</label>
                        <input type="number" x-model="cash"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            placeholder="Enter amount">
                        <p class="mt-2 text-gray-600" x-show="cash > 0">
                            Change: <span class="font-bold text-green-600"
                                x-text="'Rp ' + (cash - total).toLocaleString('id-ID')"></span>
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-white bg-primary hover:bg-opacity-90 transition shadow-lg text-lg">
                        Confirm & Pay
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection