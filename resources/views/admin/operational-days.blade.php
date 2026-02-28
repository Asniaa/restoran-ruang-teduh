@extends('layouts.app')

@section('title', 'Operational Days')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.8rem; font-family: Georgia; margin: 0;">📅 Operational Days</h2>

        @if(!$todayRecord)
            <form action="{{ route('admin.operational-days.open') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary"
                    style="padding: 0.8rem 1.5rem; background-color: #3D6B4F; border: none; border-radius: 8px; color: white; cursor: pointer;">
                    🚀 Buka Restoran Hari Ini
                </button>
            </form>
        @elseif($todayRecord->status === 'open')
            <form action="{{ route('admin.operational-days.close') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger"
                    style="padding: 0.8rem 1.5rem; background-color: #B85C5C; border: none; border-radius: 8px; color: white; cursor: pointer;">
                    🛑 Tutup Restoran Hari Ini
                </button>
            </form>
        @else
            <form action="{{ route('admin.operational-days.open') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary"
                    style="padding: 0.8rem 1.5rem; background-color: #3D6B4F; border: none; border-radius: 8px; color: white; cursor: pointer; font-weight: bold;">
                    🔄 Buka Kembali Restoran Hari Ini
                </button>
            </form>
        @endif
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Waktu Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operationalDays as $day)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($day->tanggal)->format('d F Y') }}</td>
                        <td>
                            <span class="badge {{ $day->status === 'open' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($day->status) }}
                            </span>
                        </td>
                        <td>{{ $day->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem;">Tidak ada data operational days</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($operationalDays->hasPages())
            <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
                {{ $operationalDays->links() }}
            </div>
        @endif
    </div>
@endsection