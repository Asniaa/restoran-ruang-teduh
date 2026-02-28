@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Waiter Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $order->meja->nomor_meja }}</h2>
                            <p class="text-gray-500 text-sm">#{{ $order->id }} - {{ $order->waktu_pesan->format('H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            Ready
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

                    <form action="{{ route('waiter.deliver', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 rounded-lg font-bold text-white bg-primary hover:bg-opacity-90 transition shadow-md">
                            Mark as Delivered
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No ready orders to serve.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection