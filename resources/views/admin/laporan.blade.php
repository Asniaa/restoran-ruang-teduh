@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <!-- Tailwind CDN to ensure styling works regardless of main layout config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C5D89D',
                        accent: '#3D6B4F',
                        basebg: '#FAF9EE',
                    }
                }
            }
        }
    </script>

    <div class="min-h-screen p-4 bg-basebg md:p-8 overflow-hidden font-sans">
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 mb-8 md:flex-row md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-accent" style="font-family: 'Georgia', serif;">Laporan Penjualan</h1>
                <p class="text-gray-600">Ringkasan performa penjualan Ruang Teduh</p>
            </div>
            <div class="flex items-center gap-3 px-4 py-2 bg-white border rounded-lg border-primary shadow-sm">
                <span class="text-sm font-semibold text-accent">Pilih Tahun:</span>
                <form action="{{ route('admin.laporan.index') }}" method="GET">
                    <select name="year" onchange="this.form.submit()"
                        class="bg-transparent border-none focus:ring-0 font-bold text-accent cursor-pointer">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <!-- Revenue Card -->
            <div class="bg-white p-6 rounded-xl border border-primary shadow-sm">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pendapatan</h3>
                <div class="text-2xl font-black text-accent">
                    Rp {{ number_format($todaySummary['total_pendapatan'], 0, ',', '.') }}
                </div>
                <p class="text-[10px] text-gray-400 mt-2 italic">Data transaksi hari ini</p>
            </div>

            <!-- Orders Card -->
            <div class="bg-white p-6 rounded-xl border border-primary shadow-sm">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</h3>
                <div class="text-2xl font-black text-accent">
                    {{ number_format($todaySummary['total_pesanan'], 0, ',', '.') }}
                </div>
                <p class="text-[10px] text-gray-400 mt-2 italic">Jumlah sesi pesanan hari ini</p>
            </div>

            <!-- Items Sold Card -->
            <div class="bg-white p-6 rounded-xl border border-primary shadow-sm">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Item Terjual</h3>
                <div class="text-2xl font-black text-accent">
                    {{ number_format($todaySummary['total_item'], 0, ',', '.') }}
                </div>
                <p class="text-[10px] text-gray-400 mt-2 italic">Total menu terjual hari ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mb-8">
            <!-- Top 5 Best Sellers -->
            <div class="bg-white rounded-xl border border-primary shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-primary bg-accent">
                    <h3 class="text-lg font-bold text-white">Menu Terlaris (Top 5)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase font-bold text-gray-400">
                                <th class="px-6 py-3">Ranking</th>
                                <th class="px-6 py-3">Menu</th>
                                <th class="px-6 py-3 text-center">Terjual</th>
                                <th class="px-6 py-3 text-right">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($topMenus as $index => $menu)
                                <tr class="hover:bg-basebg/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-accent">
                                        #{{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-gray-800 block leading-tight">{{ $menu->nama_menu }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $menu->nama_kategori }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 bg-primary/20 text-accent rounded-md text-xs font-bold">
                                            {{ $menu->total_dipesan }}x
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-700">
                                        Rp {{ number_format($menu->total_pendapatan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Per Category Analysis -->
            <div class="bg-white rounded-xl border border-primary shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-primary bg-accent">
                    <h3 class="text-lg font-bold text-white">Pendapatan Per Kategori</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($categoryRevenue as $category)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-bold text-gray-700">{{ $category->nama_kategori }}</span>
                                    <span class="text-xs font-bold text-accent">Rp
                                        {{ number_format($category->total_pendapatan, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    @php
                                        $maxRevenue = $categoryRevenue->max('total_pendapatan') ?: 1;
                                        $percentage = ($category->total_pendapatan / $maxRevenue) * 100;
                                    @endphp
                                    <div class="h-2.5 rounded-full bg-primary transition-all duration-700"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="mt-1 text-right">
                                    <span class="text-[10px] text-gray-400 font-medium">{{ $category->total_item }} menu
                                        terjual</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trend Table -->
        <div class="bg-white rounded-xl border border-primary shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-primary bg-accent">
                <h3 class="text-lg font-bold text-white">Tren Pendapatan Bulanan ({{ $selectedYear }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase font-bold text-gray-400">
                            <th class="px-6 py-4">Bulan</th>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($monthlyRevenue as $rev)
                            <tr class="hover:bg-basebg/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-800">
                                    {{ date("F", mktime(0, 0, 0, $rev->bulan, 10)) }}
                                </td>
                                <td class="px-6 py-4 text-gray-400 font-medium">{{ $rev->tahun }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-bold text-accent">Rp
                                        {{ number_format($rev->total, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">
                                    Belum ada data untuk tahun {{ $selectedYear }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection