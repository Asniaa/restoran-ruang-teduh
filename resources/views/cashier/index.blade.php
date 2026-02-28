@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Cashier Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $order->meja->nomor_meja }}</h2>
                        <p class="text-gray-500 text-sm">#{{ $order->id }} - {{ $order->waktu_pesan->format('H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="mb-4">
                    <p class="text-gray-600">{{ $order->detailPesanan->count() }} Items</p>
                    @php 
                        $total = 0;
                        foreach($order->detailPesanan as $d) $total += $d->kuantitas * $d->harga_saat_pesan;
                    @endphp
                    <p class="text-xl font-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>

                <a href="{{ route('cashier.show', $order->id) }}" class="block w-full py-3 rounded-lg font-bold text-white bg-blue-600 hover:bg-blue-700 text-center transition shadow-md">
                    Process Payment
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-gray-500 text-lg">No unpaid orders.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection