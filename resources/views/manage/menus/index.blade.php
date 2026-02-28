@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manage Menus</h1>
            <a href="{{ route('manage.menus.create') }}"
                class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md">
                + Add Menu
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-4 px-6">Image</th>
                        <th class="py-4 px-6">Name</th>
                        <th class="py-4 px-6">Category</th>
                        <th class="py-4 px-6 text-right">Price</th>
                        <th class="py-4 px-6 text-center">Active</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                @if($menu->foto_url)
                                    <img src="{{ asset('storage/' . $menu->foto_url) }}" alt="{{ $menu->nama_menu }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800">{{ $menu->nama_menu }}</td>
                            <td class="py-4 px-6 text-gray-600">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $menu->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-medium">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($menu->aktif)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('manage.menus.edit', $menu->id) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('manage.menus.destroy', $menu->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this menu?');" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">No menus found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $menus->links() }}
        </div>
    </div>
@endsection