@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Meja</h2>
            <p class="text-muted">Daftar meja restoran dan statusnya.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a class="btn btn-primary" href="{{ route('manage.meja.create') }}">
                <i class="bi bi-plus-lg me-1"></i> Tambah Meja
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
                        <th class="ps-4">Nomor Meja</th>
                        <th class="text-center">Kapasitas</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tables as $t)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $t->nomor_meja }}</td>
                        <td class="text-center">{{ $t->kapasitas ?? '-' }}</td>
                        <td class="text-center">
                            @if($t->status == 'available')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Available</span>
                            @elseif($t->status == 'occupied')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Occupied</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">{{ ucfirst($t->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('manage.meja.edit', $t->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="post" action="{{ route('manage.meja.destroy', $t->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?');">
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
        @if($tables instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-top py-3">
                {{ $tables->links() }}
            </div>
        @endif
    </div>
@endsection
