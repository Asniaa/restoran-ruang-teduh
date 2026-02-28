@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Cart - Meja {{ session('meja_id') }}</h1>

        @if(session('cart'))
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Menu</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Price</th>
                            <th class="py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr class="border-b border-gray-100 last:border-0">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        @if($details['foto_url'])
                                            <img src="{{ asset('storage/' . $details['foto_url']) }}" alt="{{ $details['name'] }}"
                                                class="w-12 h-12 rounded-lg object-cover mr-4">
                                        @endif
                                        <span class="font-medium text-gray-800">{{ $details['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 text-center">{{ $details['quantity'] }}</td>
                                <td class="py-4 text-right">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td class="py-4 text-right font-medium">Rp
                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-200">
                            <td colspan="3" class="py-4 text-right font-bold text-lg">Total</td>
                            <td class="py-4 text-right font-bold text-lg text-primary">Rp
                                {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('public.order.index', session('meja_id')) }}"
                    class="text-gray-600 hover:text-gray-800 font-medium">
                    &larr; Continue Ordering
                </a>
                <form action="{{ route('public.order.checkout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-lg">
                        Confirm Order
                    </button>
                </form>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <p class="text-gray-500 mb-6">Your cart is empty.</p>
                <a href="{{ route('public.order.index', session('meja_id')) }}"
                    class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-opacity-90 transition">
                    Browse Menu
                </a>
            </div>
        @endif
    </div>
@endsection