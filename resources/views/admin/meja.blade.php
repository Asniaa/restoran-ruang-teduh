@extends('layouts.app')

@section('title', 'Kelola Meja')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.8rem; font-family: Georgia;">🪑 Kelola Meja</h2>
        <button class="btn btn-primary" onclick="openModal('mejaModal'); resetMejaForm();">+ Tambah Meja</button>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
            @forelse($mejas as $meja)
                <div style="border: 2px solid #C5D89D; border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <h3 style="margin-bottom: 1rem;">Meja {{ $meja->nomor_meja }}</h3>
                    <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Status: 
                        <span class="badge {{ $meja->status === 'available' ? 'badge-success' : 'badge-danger' }}">
                            {{ $meja->status }}
                        </span>
                    </p>
                    <div style="margin: 1rem 0; display: flex; flex-direction: column; gap: 0.5rem;">
                        <button class="btn btn-primary" style="width: 100%; font-size: 0.85rem;" onclick="generateQR({{ $meja->id }})">Generate QR</button>
                        <a href="{{ route('admin.meja.downloadQR', $meja->id) }}" class="btn btn-success" style="width: 100%; display: block; text-align: center; font-size: 0.85rem;">Download QR</a>
                        <button class="btn btn-warning" style="width: 100%; font-size: 0.85rem;" onclick="editMeja({{ $meja->id }})">Edit</button>
                        <form method="POST" action="{{ route('admin.meja.delete', $meja->id) }}" style="width: 100%;" onsubmit="return confirm('Yakin hapus meja ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%; font-size: 0.85rem;">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; grid-column: 1/-1;">Tidak ada meja</div>
            @endforelse
        </div>
    </div>

    <div id="mejaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="mejaModalTitle">Tambah Meja</h3>
                <button class="modal-close" onclick="closeModal('mejaModal'); resetMejaForm();">&times;</button>
            </div>
            <form id="mejaForm" onsubmit="submitMejaForm(event)">
                @csrf
                <input type="hidden" id="meja_id">
                <input type="hidden" id="meja_method" value="POST">
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="text" name="nomor_meja" id="nomor_meja" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeModal('mejaModal'); resetMejaForm();">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editMeja(id) {
            fetch('/admin/meja/' + id + '/edit-api')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('mejaModalTitle').textContent = 'Edit Meja';
                    document.getElementById('meja_id').value = d.id;
                    document.getElementById('nomor_meja').value = d.nomor_meja;
                    document.getElementById('status').value = d.status;
                    document.getElementById('meja_method').value = 'PUT';
                    openModal('mejaModal');
                });
        }
        
        function resetMejaForm() {
            document.getElementById('mejaForm').reset();
            document.getElementById('mejaModalTitle').textContent = 'Tambah Meja';
            document.getElementById('meja_id').value = '';
            document.getElementById('meja_method').value = 'POST';
        }
        
        function submitMejaForm(e) {
            e.preventDefault();
            const form = document.getElementById('mejaForm');
            const id = document.getElementById('meja_id').value;
            const method = document.getElementById('meja_method').value;
            const url = method === 'PUT' ? '/admin/meja/' + id : '/admin/meja';
            const formData = new FormData(form);
            
            // Add method override for PUT
            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }
            
            fetch(url, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: formData
            })
            .then(r => {
                if (r.status === 422) {
                    return r.json().then(data => {
                        const errors = data.errors;
                        const errorMsg = Object.keys(errors).map(field => {
                            return field + ': ' + errors[field].join(', ');
                        }).join('\n');
                        alert('Validation Error:\n' + errorMsg);
                        throw new Error('Validation failed');
                    });
                }
                if (!r.ok) throw new Error('Network response was not ok');
                return r.text();
            })
            .then(() => {
                alert('Berhasil disimpan!');
                location.reload();
            })
            .catch(e => {
                if (e.message !== 'Validation failed') {
                    alert('Error: ' + e.message);
                }
            });
        }

        function generateQR(mejaId) {
            fetch('/admin/meja/generate-qr/' + mejaId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(r => r.json()).then(d => {
                alert(d.message || 'QR Code generated!');
                location.reload();
            }).catch(e => alert('Error: ' + e));
        }
    </script>
@endsection
