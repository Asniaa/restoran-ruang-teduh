@extends('layouts.app')

@section('title', 'Kelola Kategori')

@push('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #dee2e6;
    }
    .header-container h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.75rem;
        color: #333;
    }
    .action-buttons .btn {
        margin-left: 0.5rem;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 5px;
    }
    .action-buttons form {
        display: inline-block;
    }
    .badge-count {
        background-color: #3D6B4F;
        color: white;
        padding: 0.4em 0.7em;
        border-radius: 10px;
        font-weight: 600;
    }
    .table th {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
    <div class="header-container">
        <h2><i class="fas fa-tags"></i> Kelola Kategori</h2>
        <button class="btn btn-primary" onclick="openModal('kategoriModal')">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Jumlah Menu</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kat)
                        <tr>
                            <td>#{{ $kat->id }}</td>
                            <td>{{ $kat->nama_kategori }}</td>
                            <td class="text-center"><span class="badge-count">{{ $kat->menu_count }}</span></td>
                            <td class="text-right action-buttons">
                                <button class="btn btn-sm btn-success" onclick="editKategori({{ $kat->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.kategori.delete', $kat->id) }}" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Tidak ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div id="kategoriModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="kategoriModalTitle">Tambah Kategori</h3>
                <button class="modal-close" onclick="closeModal('kategoriModal'); resetKategoriForm();">&times;</button>
            </div>
            <form id="kategoriForm" onsubmit="submitKategoriForm(event)" class="p-3">
                @csrf
                <input type="hidden" id="kategori_id">
                <input type="hidden" id="kategori_method" value="POST">
                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                </div>
                <div class="form-actions text-right">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('kategoriModal'); resetKategoriForm();">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function editKategori(id) {
        fetch(`/admin/kategori/${id}/edit-api`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data');
                return response.json();
            })
            .then(data => {
                document.getElementById('kategoriModalTitle').textContent = 'Edit Kategori';
                document.getElementById('kategori_id').value = data.id;
                document.getElementById('nama_kategori').value = data.nama_kategori;
                document.getElementById('kategori_method').value = 'PUT';
                openModal('kategoriModal');
            })
            .catch(error => console.error('Error:', error));
    }
    
    function resetKategoriForm() {
        document.getElementById('kategoriForm').reset();
        document.getElementById('kategoriModalTitle').textContent = 'Tambah Kategori';
        document.getElementById('kategori_id').value = '';
        document.getElementById('kategori_method').value = 'POST';
    }
    
    function submitKategoriForm(event) {
        event.preventDefault();
        const form = document.getElementById('kategoriForm');
        const id = document.getElementById('kategori_id').value;
        const method = document.getElementById('kategori_method').value;
        let url = '/admin/kategori/create';
        let fetchMethod = 'POST';

        const formData = new FormData(form);

        if (id) {
            url = `/admin/kategori/${id}`;
            formData.append('_method', 'PUT');
        }
        
        fetch(url, {
            method: 'POST', // Tetap POST karena form method spoofing
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (response.status === 422) {
                return response.json().then(data => {
                    const errorMsg = Object.values(data.errors).flat().join('\n');
                    alert('Error Validasi:\n' + errorMsg);
                    throw new Error('Validation failed');
                });
            }
            if (!response.ok) {
                throw new Error('Terjadi kesalahan pada server.');
            }
            // Cek jika responsnya JSON atau tidak
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json();
            } else {
                return response.text().then(text => {
                    // Jika sukses tapi bukan JSON (misal redirect)
                    return { success: true, message: 'Operasi berhasil!' };
                });
            }
        })
        .then(data => {
            alert(data.message || 'Berhasil disimpan!');
            location.reload();
        })
        .catch(error => {
            if (error.message !== 'Validation failed') {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            }
        });
    }
</script>
@endpush
