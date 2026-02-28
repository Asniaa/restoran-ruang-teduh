@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daily Sales Report</h1>
                <p class="text-gray-600 mt-1">Detailed summary of transactions and performance.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.index') }}"
                    class="flex items-center px-4 py-2 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.operational-days.index') }}"
                    class="flex items-center px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-opacity-90 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Select Date
                </a>
            </div>
        </div>

        @if($day)
            <div class="bg-gradient-to-r from-primary to-primary/80 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h5 class="text-white/70 font-medium uppercase tracking-wider text-xs mb-1">Report Date</h5>
                        <h2 class="text-3xl font-bold">{{ \Carbon\Carbon::parse($day->tanggal)->format('l, d F Y') }}</h2>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/30 text-center">
                        <h5 class="text-white/70 text-xs uppercase tracking-wider mb-1">Status</h5>
                        <span class="text-lg font-bold uppercase">{{ $day->status }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(!$summary)
            <div class="bg-blue-50 border border-blue-100 text-blue-700 p-6 rounded-2xl flex items-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium">No sales data available for the selected operational day.</p>
            </div>
        @else
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h6 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Orders</h6>
                    <p class="text-3xl font-bold text-gray-800">{{ $summary['orders'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h6 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Payments</h6>
                    <p class="text-3xl font-bold text-green-600">{{ $summary['payments'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sm:col-span-2">
                    <h6 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Revenue</h6>
                    <p class="text-3xl font-bold text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Payment Breakdown --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 rounded-t-2xl">
                        <h5 class="font-bold text-gray-700">Payment Breakdown</h5>
                    </div>
                    <div class="p-6 space-y-4 flex-1">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200/50">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-700">Cash Payments</span>
                            </div>
                            <span class="font-bold text-lg text-gray-800">Rp
                                {{ number_format($summary['methods']['cash'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200/50">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M4 16h2M6 20h2M4 4h4m12 0h.01M4 8h2m10 0h.01" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-700">QRIS Payments</span>
                            </div>
                            <span class="font-bold text-lg text-gray-800">Rp
                                {{ number_format($summary['methods']['qris'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Top Selling Menus --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 rounded-t-2xl">
                        <h5 class="font-bold text-gray-700">Daily Sales Detail</h5>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b border-gray-100">
                                    <th class="py-4 px-6">Menu Item</th>
                                    <th class="py-4 px-6 text-center">Qty</th>
                                    <th class="py-4 px-6 text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($items as $it)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6 font-semibold text-gray-700">{{ $it['menu'] }}</td>
                                        <td class="py-4 px-6 text-center text-gray-600 font-medium">
                                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $it['qty'] }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-right font-bold text-gray-800 italic">Rp
                                            {{ number_format($it['revenue'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-gray-400 italic font-medium">No menu sales
                                            recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection