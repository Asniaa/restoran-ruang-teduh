@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Ruang Teduh</h1>
            <p class="text-gray-600">Meja {{ $no_meja }}</p>
        </div>
        <a href="{{ route('public.order.cart') }}" class="relative bg-primary text-white p-3 rounded-full hover:bg-opacity-90 transition shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            @if(session('cart'))
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ count(session('cart')) }}
                </span>
            @endif
        </a>
    </div>

    {{-- Category Tabs --}}
    <div class="flex overflow-x-auto space-x-4 mb-8 pb-2">
        <button class="bg-primary text-white px-6 py-2 rounded-full font-medium shadow-sm whitespace-nowrap">
            All
        </button>
        @foreach($categories as $category)
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-medium shadow-sm whitespace-nowrap hover:bg-gray-50">
                {{ $category->nama_kategori }}
            </button>
        @endforeach
    </div>

    {{-- Menu Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col h-full">
                <div class="h-48 bg-gray-200 w-full object-cover">
                    {{-- Validasi jika ada foto_url --}}
                    @if($menu->foto_url)
                        <img src="{{ asset('storage/' . $menu->foto_url) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-800">{{ $menu->nama_menu }}</h3>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $menu->kategori->nama_kategori ?? '' }}</span>
                    </div>
                    <p class="text-primary font-bold text-xl mb-4">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    
                    <div class="mt-auto">
                        <form action="{{ route('public.order.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <div class="flex items-center space-x-2">
                                <input type="number" name="quantity" value="1" min="1" class="w-16 rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-center">
                                <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-lg font-medium hover:bg-opacity-90 transition">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection