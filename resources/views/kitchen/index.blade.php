@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Kitchen Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($orders as $order)
                <div
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 {{ $order->status == 'open' ? 'border-red-500' : 'border-yellow-500' }}">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $order->meja->nomor_meja }}</h2>
                            <p class="text-gray-500 text-sm">#{{ $order->id }} - {{ $order->waktu_pesan->format('H:i') }}</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-bold {{ $order->status == 'open' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <hr class="mb-4">

                    <ul class="space-y-3 mb-6">
                        @foreach($order->detailPesanan as $detail)
                            <li class="flex justify-between">
                                <div>
                                    <span class="font-bold text-gray-800">{{ $detail->kuantitas }}x</span>
                                    <span class="text-gray-700">{{ $detail->menu->nama_menu }}</span>
                                    @if($detail->catatan)
                                        <p class="text-sm text-gray-500 italic">Note: {{ $detail->catatan }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('kitchen.update-status', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 rounded-lg font-bold text-white transition shadow-md {{ $order->status == 'open' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }}">
                            @if($order->status == 'open')
                                Start Preparing
                            @else
                                Mark as Ready
                            @endif
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <p class="text-gray-500 text-lg">No active orders in the kitchen.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection