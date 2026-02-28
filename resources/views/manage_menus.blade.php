@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Menu</h2>
            <p class="text-muted">Daftar semua menu yang tersedia.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a class="btn btn-primary" href="{{ route('manage.menus.create') }}">
                <i class="bi bi-plus-lg me-1"></i> Tambah Menu
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
                        <th class="ps-4">Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($menus as $m)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $m->nama_menu }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $m->kategori?->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="fw-medium">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($m->aktif)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('manage.menus.edit', $m->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="post" action="{{ route('manage.menus.destroy', $m->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
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
        @if($menus instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-top py-3">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
@endsection
