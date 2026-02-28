@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.8rem; font-family: Georgia;">👥 Kelola Karyawan</h2>
        <button class="btn btn-primary" onclick="openModal('karyawanModal'); resetKaryawanForm();">+ Tambah Karyawan</button>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawans as $karyawan)
                    <tr>
                        <td>{{ $karyawan->nama }}</td>
                        <td>{{ $karyawan->user->email ?? '-' }}</td>
                        <td>
                            @if($karyawan->user)
                            <span class="badge" style="background: {{ $karyawan->user->role === 'admin' ? '#3D6B4F' : ($karyawan->user->role === 'dapur' ? '#E8B84B' : ($karyawan->user->role === 'pelayan' ? '#6B9D7F' : '#B85C5C')) }}; padding: 0.3rem 0.6rem; border-radius: 4px; color: white;">
                                {{ ucfirst($karyawan->user->role) }}
                            </span>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $karyawan->aktif ? 'badge-success' : 'badge-danger' }}">
                                {{ $karyawan->aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-success" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;" onclick="editKaryawan({{ $karyawan->id }})">Edit</button>
                            <form method="POST" action="{{ route('admin.karyawan.delete', $karyawan->id) }}" style="display: inline;" onsubmit="return confirm('Yakin hapus karyawan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem;">Tidak ada karyawan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($karyawans->hasPages())
            <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
                {{ $karyawans->links() }}
            </div>
        @endif
    </div>

    <div id="karyawanModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="karyawanModalTitle">Tambah Karyawan</h3>
                <button class="modal-close" onclick="closeModal('karyawanModal'); resetKaryawanForm();">&times;</button>
            </div>
            <form id="karyawanForm" onsubmit="submitKaryawanForm(event)">
                @csrf
                <input type="hidden" id="karyawan_id">
                <input type="hidden" id="karyawan_method" value="POST">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="dapur">Dapur</option>
                        <option value="pelayan">Pelayan</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
                <div class="form-group" id="passwordGroup">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group" id="aktifGroup" style="display: none;">
                    <label><input type="checkbox" name="aktif" id="aktif" value="1"> Aktif</label>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeModal('karyawanModal'); resetKaryawanForm();">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editKaryawan(id) {
            fetch('/admin/karyawan/' + id + '/edit-api')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('karyawanModalTitle').textContent = 'Edit Karyawan';
                    document.getElementById('karyawan_id').value = d.id;
                    document.getElementById('nama').value = d.nama;
                    document.getElementById('email').value = d.email;
                    document.getElementById('role').value = d.role;
                    document.getElementById('aktif').checked = d.aktif;
                    document.getElementById('passwordGroup').style.display = 'none';
                    document.getElementById('aktifGroup').style.display = 'block';
                    document.getElementById('password').removeAttribute('required');
                    document.getElementById('karyawan_method').value = 'PUT';
                    openModal('karyawanModal');
                });
        }
        
        function resetKaryawanForm() {
            document.getElementById('karyawanForm').reset();
            document.getElementById('karyawanModalTitle').textContent = 'Tambah Karyawan';
            document.getElementById('karyawan_id').value = '';
            document.getElementById('passwordGroup').style.display = 'block';
            document.getElementById('aktifGroup').style.display = 'none';
            document.getElementById('password').setAttribute('required', 'required');
            document.getElementById('karyawan_method').value = 'POST';
        }
        
        function submitKaryawanForm(e) {
            e.preventDefault();
            const form = document.getElementById('karyawanForm');
            const id = document.getElementById('karyawan_id').value;
            const method = document.getElementById('karyawan_method').value;
            const url = method === 'PUT' ? '/admin/karyawan/' + id : '/admin/karyawan';
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
    </script>
@endsection
