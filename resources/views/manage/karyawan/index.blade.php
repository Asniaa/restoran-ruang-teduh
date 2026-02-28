@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Karyawan Management</h1>
            <a href="{{ route('manage.karyawan.create') }}"
                class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md">
                + Add Employee
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
                        <th class="py-4 px-6">Name</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Linked User Account</th>
                        <th class="py-4 px-6 text-center">Active</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($staff as $karyawan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-medium text-gray-800">{{ $karyawan->nama }}</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-blue-100 text-blue-800">
                                    {{ $karyawan->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                @if($karyawan->user)
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $karyawan->user->email }}
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">No account linked</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($karyawan->aktif)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('manage.karyawan.edit', $karyawan->id) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('manage.karyawan.destroy', $karyawan->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this employee?');" class="inline">
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
                            <td colspan="5" class="py-12 text-center text-gray-500">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $staff->links() }}
        </div>
    </div>
@endsection