@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manage Tables</h1>
            <a href="{{ route('manage.meja.create') }}"
                class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md">
                + Add Table
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($tables as $table)
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center relative group">
                    <div class="text-3xl font-bold text-gray-800 mb-2">{{ $table->nomor_meja }}</div>

                    @php
                        $statusColor = match ($table->status) {
                            'available' => 'bg-green-100 text-green-800',
                            'booked' => 'bg-yellow-100 text-yellow-800',
                            'occupied' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColor }}">
                        {{ $table->status }}
                    </span>

                    <div
                        class="absolute inset-0 bg-black/5 rounded-xl opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-2 backdrop-blur-[1px]">
                        <a href="{{ route('manage.meja.edit', $table->id) }}"
                            class="bg-white text-blue-600 p-2 rounded-full shadow-sm hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                        <form action="{{ route('manage.meja.destroy', $table->id) }}" method="POST"
                            onsubmit="return confirm('Delete this table?');">
                            @csrf
                            <button type="submit"
                                class="bg-white text-red-600 p-2 rounded-full shadow-sm hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm text-gray-500">
                    No tables found.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $tables->links() }}
        </div>
    </div>
@endsection