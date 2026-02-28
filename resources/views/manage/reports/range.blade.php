@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Period Report</h1>
                <p class="text-gray-600 mt-1">Summary of transactions across a custom date range.</p>
            </div>
            <div>
                <a href="{{ route('admin.index') }}"
                    class="flex items-center px-4 py-2 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <form method="get" action="{{ route('admin.reports.range') }}" class="flex flex-col md:flex-row items-end gap-6">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">From Date</label>
                    <input type="date" name="from"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 transition"
                        value="{{ request('from') }}">
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">To Date</label>
                    <input type="date" name="to"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 transition"
                        value="{{ request('to') }}">
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit"
                        class="w-full bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        @if(isset($rows) && count($rows) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b border-gray-100">
                                <th class="py-5 px-6">Date</th>
                                <th class="py-5 px-6 text-center">Orders</th>
                                <th class="py-5 px-6 text-center">Paid</th>
                                <th class="py-5 px-6 text-right">Revenue</th>
                                <th class="py-5 px-6 text-right">Cash</th>
                                <th class="py-5 px-6 text-right">QRIS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($rows as $r)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-5 px-6">
                                        <span
                                            class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($r['tanggal'])->format('d M Y') }}</span>
                                        <span
                                            class="block text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($r['tanggal'])->format('l') }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <span
                                            class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">{{ $r['orders'] }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-center text-gray-600 font-medium">
                                        {{ $r['payments'] }}
                                    </td>
                                    <td class="py-5 px-6 text-right font-bold text-primary italic text-lg">Rp
                                        {{ number_format($r['total'], 0, ',', '.') }}</td>
                                    <td class="py-5 px-6 text-right font-medium text-gray-600">Rp
                                        {{ number_format($r['cash'], 0, ',', '.') }}</td>
                                    <td class="py-5 px-6 text-right font-medium text-gray-600">Rp
                                        {{ number_format($r['qris'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/80 font-bold border-t border-gray-200">
                            <tr class="text-gray-800">
                                <td class="py-6 px-6">Period Total</td>
                                <td class="py-6 px-6 text-center">{{ collect($rows)->sum('orders') }}</td>
                                <td class="py-6 px-6 text-center">{{ collect($rows)->sum('payments') }}</td>
                                <td class="py-6 px-6 text-right text-primary text-xl">Rp
                                    {{ number_format(collect($rows)->sum('total'), 0, ',', '.') }}</td>
                                <td class="py-6 px-6 text-right">Rp
                                    {{ number_format(collect($rows)->sum('cash'), 0, ',', '.') }}</td>
                                <td class="py-6 px-6 text-right">Rp
                                    {{ number_format(collect($rows)->sum('qris'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @elseif(request('from') || request('to'))
            <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-gray-200 shadow-sm mt-8">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No data found</h3>
                <p class="text-gray-500 max-w-xs mx-auto">There are no transactions recorded for the selected date range.</p>
            </div>
        @endif
    </div>
@endsection