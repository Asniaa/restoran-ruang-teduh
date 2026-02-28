@extends('layouts.app')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-text-dark">Dashboard Owner</h1>
            <p class="text-text-medium mt-1">Welcome back, {{ Auth::user()->name ?? 'Budi Santoso' }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('manage.menus.create') }}" class="btn-primary inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Menu
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <p class="text-text-medium text-sm font-medium">Total Penjualan Hari Ini</p>
            <p class="text-3xl font-bold text-text-dark mt-2">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <p class="text-text-medium text-sm font-medium">Pesanan Aktif</p>
            <p class="text-3xl font-bold text-text-dark mt-2">{{ $activeOrders }}</p>
        </div>
        <div class="card">
            <p class="text-text-medium text-sm font-medium">Meja Terisi</p>
            <p class="text-3xl font-bold text-text-dark mt-2">{{ $occupiedTables }}/{{ $totalTables }}</p>
        </div>
        <div class="card">
            <p class="text-text-medium text-sm font-medium">Revenue Bulan Ini</p>
            <p class="text-3xl font-bold text-text-dark mt-2">Rp {{ number_format($revenueMonth, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Menu Terlaris -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-text-dark">Menu Terlaris</h2>
            <a href="{{ route('manage.menus.create') }}" class="btn-secondary inline-flex items-center text-sm">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Menu
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-medium uppercase tracking-wider">Menu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-medium uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-medium uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-medium uppercase tracking-wider">Terjual</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bestSellingMenus as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-dark">{{ $item->menu->nama_menu }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-medium">{{ $item->menu->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-medium">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-medium">{{ $item->total_sold }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('manage.menus.edit', $item->menu_id) }}" class="btn-action-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-text-medium text-center">Belum ada data penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection