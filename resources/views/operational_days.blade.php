@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Hari Operasional</h2>
            <p class="text-muted">Riwayat dan status operasional restoran.</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
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
                        <th class="ps-4">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($days as $d)
                    <tr>
                        <td class="ps-4 fw-medium">{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td class="text-center">
                            @if($d->status == 'open')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Open</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Closed</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <form method="post" action="{{ route('operational-days.toggle', $d->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $d->status == 'open' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    @if($d->status == 'open')
                                        <i class="bi bi-x-circle me-1"></i> Tutup
                                    @else
                                        <i class="bi bi-check-circle me-1"></i> Buka
                                    @endif
                                </button>
                            </form>
                            <a href="{{ route('reports.daily.detail', $d->id) }}" class="btn btn-sm btn-outline-info ms-2">
                                <i class="bi bi-file-text"></i> Laporan
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($days, 'links'))
            <div class="card-footer bg-white border-top py-3">
                {{ $days->links() }}
            </div>
        @endif
    </div>
@endsection
