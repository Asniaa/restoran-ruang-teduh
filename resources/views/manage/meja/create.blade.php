@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-lg mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('manage.meja.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Add New Table</h1>
            </div>

            <div class="bg-white rounded-xl shadow-md p-8">
                <form action="{{ route('manage.meja.store') }}" method="POST">
                    @csrf

                    {{-- Table Number --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Table Number</label>
                        <input type="text" name="nomor_meja" value="{{ old('nomor_meja') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            placeholder="e.g. Meja 01" required>
                        @error('nomor_meja')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-8">
                        <label class="block text-gray-700 font-bold mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-lg">
                            Save Table
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection