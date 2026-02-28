@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Operational Days</h1>

            <form action="{{ route('admin.operational-days.index') }}" method="POST"> {{-- Note: Adjusting to match admin
                group --}}
                @csrf
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md">
                    + Start New Day
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-4 px-6">Date</th>
                        <th class="py-4 px-6">Day</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($days as $day)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-medium text-gray-800">{{ $day->tanggal->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ $day->tanggal->format('l') }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($day->status == 'open')
                                    <span
                                        class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Open</span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold uppercase">Closed</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{-- Actions --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">No operational days found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $days->links() }}
        </div>
    </div>
@endsection