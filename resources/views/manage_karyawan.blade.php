@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Karyawan</h2>
            <p class="text-muted">Daftar karyawan dan hak akses.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a class="btn btn-primary" href="{{ route('manage.karyawan.create') }}">
                <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Role</th>
                        <th>User Email</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($staff as $s)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $s->nama }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($s->role) }}</span>
                        </td>
                        <td>{{ $s->user?->email ?? '-' }}</td>
                        <td class="text-center">
                            @if($s->aktif)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('manage.karyawan.edit', $s->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="post" action="{{ route('manage.karyawan.destroy', $s->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($staff instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-top py-3">
                {{ $staff->links() }}
            </div>
        @endif
    </div>
@endsection
