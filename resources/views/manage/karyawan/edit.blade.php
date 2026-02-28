@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('manage.karyawan.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Edit Employee</h1>
            </div>

            <div class="bg-white rounded-xl shadow-md p-8">
                <form action="{{ route('manage.karyawan.update', $karyawan->id) }}" method="POST">
                    @csrf
                    @method('POST')

                    {{-- Name --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Full Name</label>
                        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Role</label>
                        <select name="role"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                            <option value="">Select Role</option>
                            <option value="owner" {{ old('role', $karyawan->role) == 'owner' ? 'selected' : '' }}>Owner
                            </option>
                            <option value="kasir" {{ old('role', $karyawan->role) == 'kasir' ? 'selected' : '' }}>Cashier
                                (Kasir)</option>
                            <option value="pelayan" {{ old('role', $karyawan->role) == 'pelayan' ? 'selected' : '' }}>Waiter
                                (Pelayan)</option>
                            <option value="dapur" {{ old('role', $karyawan->role) == 'dapur' ? 'selected' : '' }}>Kitchen
                                (Dapur)</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link User Account --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Link User Account (Optional)</label>
                        <select name="user_id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">No Account Linked</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $karyawan->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @if($karyawan->user_id && !$users->contains('id', $karyawan->user_id))
                            <p class="text-sm text-blue-600 mt-1">Currently linked to: {{ $karyawan->user->email }} (Not in list
                                to preserve selection)</p>
                        @endif
                        <p class="text-gray-500 text-sm mt-1">Select an existing user account to grant access to this
                            employee.</p>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Active --}}
                    <div class="mb-8">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" name="aktif" value="1" class="sr-only peer" {{ old('aktif', $karyawan->aktif) ? 'checked' : '' }}>
                                <div
                                    class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                            <span class="ml-3 text-gray-700 font-medium">Active (Can log in if linked)</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-lg">
                            Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection