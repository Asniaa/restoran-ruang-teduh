@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('manage.menus.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Edit Menu</h1>
            </div>

            <div class="bg-white rounded-xl shadow-md p-8">
                <form action="{{ route('manage.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST') {{-- Or override route to use PUT? web.php says POST for update --}}

                    {{-- Name --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Menu Name</label>
                        <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                        @error('nama_menu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Category --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Category</label>
                            <select name="kategori_id"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id', $menu->kategori_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Price (Rp)</label>
                            <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                required>
                            @error('harga')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Photo --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Photo</label>
                        @if($menu->foto_url)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $menu->foto_url) }}" alt="Current Photo"
                                    class="w-32 h-32 rounded-lg object-cover">
                            </div>
                        @endif
                        <input type="file" name="foto"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            accept="image/*">
                        <p class="text-gray-500 text-sm mt-1">Leave blank to keep current photo. Max 2MB.</p>
                        @error('foto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Active --}}
                    <div class="mb-8">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" name="aktif" value="1" class="sr-only peer" {{ old('aktif', $menu->aktif) ? 'checked' : '' }}>
                                <div
                                    class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                            <span class="ml-3 text-gray-700 font-medium">Active (Available for order)</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-lg">
                            Update Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection