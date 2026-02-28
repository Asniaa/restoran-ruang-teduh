@extends('layouts.app')

@section('title', 'Kelola Menu')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.8rem; font-family: Georgia;">🍖 Kelola Menu</h2>
        <button class="btn btn-primary" onclick="openModal('menuModal')">+ Tambah Menu</button>
    </div>

    <!-- Search -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <form method="GET" style="display: flex; gap: 1rem;">
            <input type="text" name="search" placeholder="Cari menu..." value="{{ request('search') }}" style="flex: 1;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>#{{ $menu->id }}</td>
                        <td>
                            @if($menu->foto)
                                @if(filter_var($menu->foto, FILTER_VALIDATE_URL))
                                    <img src="{{ $menu->foto }}" alt="{{ $menu->nama_menu }}" style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover;">
                                @endif
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td>{{ $menu->nama_menu }}</td>
                        <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format((float)$menu->harga, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $menu->aktif ? 'badge-success' : 'badge-danger' }}">{{ $menu->aktif ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                        <td>
                            <button class="btn btn-success" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;" onclick="editMenu({{ $menu->id }})">Edit</button>
                            <form method="POST" action="{{ route('admin.menu.delete', $menu->id) }}" style="display: inline;" onsubmit="return confirm('Yakin hapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align: center; padding: 2rem;">Tidak ada menu</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1rem;">{{ $menus->links() }}</div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="menuModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="menuModalTitle">Tambah Menu</h3>
                <button class="modal-close" onclick="closeModal('menuModal'); resetMenuForm();">&times;</button>
            </div>
            <form id="menuForm" onsubmit="submitMenuForm(event)">
                @csrf
                <input type="hidden" id="menu_id">
                <input type="hidden" id="menu_method" value="POST">
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" id="nama_menu" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" id="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\KategoriMenu::all() as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" id="harga" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Foto Menu</label>
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                        <button type="button" class="btn" id="tabUpload" style="flex: 1; background: #3D6B4F; color: white;" onclick="switchFotoTab('upload')">📤 Upload File</button>
                        <button type="button" class="btn" id="tabLink" style="flex: 1; background: #C5D89D; color: #2C4A32;" onclick="switchFotoTab('link')">🔗 Paste Link</button>
                    </div>
                    
                    <!-- Upload File Tab -->
                    <div id="uploadTab" style="display: block;">
                        <input type="file" name="foto" id="foto" accept="image/*">
                        <small style="color: #666; display: block; margin-top: 0.5rem;">Max 2MB. Format: JPG, PNG, GIF</small>
                    </div>
                    
                    <!-- Paste Link Tab -->
                    <div id="linkTab" style="display: none;">
                        <input type="url" name="foto_url" id="foto_url" placeholder="Paste link gambar (https://...)">
                        <small style="color: #666; display: block; margin-top: 0.5rem;">Contoh: https://example.com/image.jpg</small>
                    </div>
                    
                    <div id="fotoPreview" style="margin-top: 1rem; text-align: center;"></div>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="aktif" id="aktif" value="1"> Aktif</label>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeModal('menuModal'); resetMenuForm();">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editMenu(id) {
            fetch('/admin/menu/' + id + '/edit-api')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('menuModalTitle').textContent = 'Edit Menu';
                    document.getElementById('menu_id').value = d.id;
                    document.getElementById('nama_menu').value = d.nama_menu;
                    document.getElementById('kategori_id').value = d.kategori_id;
                    document.getElementById('harga').value = d.harga;
                    document.getElementById('aktif').checked = d.aktif;
                    document.getElementById('menu_method').value = 'PUT';
                    
                    // Show existing foto preview
                    const preview = document.getElementById('fotoPreview');
                    if (d.foto) {
                        // Check if foto is URL or local file
                        const isUrl = d.foto.startsWith('http://') || d.foto.startsWith('https://');
                        const fotoSrc = isUrl ? d.foto : ('{{ asset("storage") }}/' + d.foto);
                        preview.innerHTML = '<img src="' + fotoSrc + '" style="max-width: 200px; max-height: 150px; border-radius: 8px;">';
                    } else {
                        preview.innerHTML = '';
                    }
                    
                    openModal('menuModal');
                });
        }
        
        function resetMenuForm() {
            document.getElementById('menuForm').reset();
            document.getElementById('menuModalTitle').textContent = 'Tambah Menu';
            document.getElementById('menu_id').value = '';
            document.getElementById('menu_method').value = 'POST';
            document.getElementById('fotoPreview').innerHTML = '';
            switchFotoTab('upload');
        }
        
        // Switch between upload file and link tab
        function switchFotoTab(tab) {
            const uploadTab = document.getElementById('uploadTab');
            const linkTab = document.getElementById('linkTab');
            const btnUpload = document.getElementById('tabUpload');
            const btnLink = document.getElementById('tabLink');
            
            if (tab === 'upload') {
                uploadTab.style.display = 'block';
                linkTab.style.display = 'none';
                btnUpload.style.background = '#3D6B4F';
                btnUpload.style.color = 'white';
                btnLink.style.background = '#C5D89D';
                btnLink.style.color = '#2C4A32';
                document.getElementById('foto_url').value = '';
            } else {
                uploadTab.style.display = 'none';
                linkTab.style.display = 'block';
                btnUpload.style.background = '#C5D89D';
                btnUpload.style.color = '#2C4A32';
                btnLink.style.background = '#3D6B4F';
                btnLink.style.color = 'white';
                document.getElementById('foto').value = '';
            }
            document.getElementById('fotoPreview').innerHTML = '';
        }
        
        // Preview foto saat dipilih (file)
        document.getElementById('foto').addEventListener('change', function(e) {
            const preview = document.getElementById('fotoPreview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = '<img src="' + event.target.result + '" style="max-width: 200px; max-height: 150px; border-radius: 8px;">';
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
        
        // Preview foto saat paste URL
        document.getElementById('foto_url').addEventListener('change', function(e) {
            const preview = document.getElementById('fotoPreview');
            const url = e.target.value.trim();
            
            if (url) {
                preview.innerHTML = '<img src="' + url + '" style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;" onerror="this.parentElement.innerHTML=\'❌ URL gambar tidak valid\'">';
            } else {
                preview.innerHTML = '';
            }
        });
        
        function submitMenuForm(e) {
            e.preventDefault();
            const form = document.getElementById('menuForm');
            const id = document.getElementById('menu_id').value;
            const method = document.getElementById('menu_method').value;
            const url = method === 'PUT' ? '/admin/menu/' + id : '/admin/menu/create';
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
