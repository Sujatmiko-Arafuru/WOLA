@extends('layouts.admin')

@section('title', 'Edit Akun Pegawai')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-edit me-2"></i>Edit Akun Pegawai
                        </h5>
                        <p class="text-muted mb-0">Edit informasi akun pegawai</p>
                    </div>
                    <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Pegawai
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/kelola-akun/{{ $user->id }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">
                                <i class="fas fa-id-card me-2"></i>NIP
                            </label>
                            <input type="text" 
                                   class="form-control @error('nip') is-invalid @enderror" 
                                   id="nip" 
                                   name="nip" 
                                   value="{{ old('nip', $user->nip) }}" 
                                   placeholder="Masukkan NIP"
                                   required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="Masukkan email"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">
                                <i class="fas fa-briefcase me-2"></i>Jabatan
                            </label>
                            <input type="text" 
                                   class="form-control @error('position') is-invalid @enderror" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position', $user->position) }}" 
                                   placeholder="Masukkan jabatan"
                                   required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="unit" class="form-label">
                                <i class="fas fa-building me-2"></i>Unit
                            </label>
                            <div class="dropdown-search-wrapper">
                                <input type="text" 
                                       class="form-control dropdown-search-input @error('unit') is-invalid @enderror" 
                                       id="unit-search" 
                                       placeholder="Cari atau pilih unit..."
                                       autocomplete="off">
                                <input type="hidden" 
                                       name="unit" 
                                       id="unit" 
                                       value="{{ old('unit', $user->unit) }}" 
                                       required>
                                <div class="dropdown-search-menu" id="unit-dropdown">
                                    <div class="dropdown-search-item" data-value="Unit IT">Unit IT</div>
                                    <div class="dropdown-search-item" data-value="Unit Pengelola Usaha">Unit Pengelola Usaha</div>
                                    <div class="dropdown-search-item" data-value="Unit Pengembangan Bahasa">Unit Pengembangan Bahasa</div>
                                    <div class="dropdown-search-item" data-value="Unit Laboratorium Terpadu">Unit Laboratorium Terpadu</div>
                                    <div class="dropdown-search-item" data-value="Unit Perpustakaan Terpadu">Unit Perpustakaan Terpadu</div>
                                    <div class="dropdown-search-item" data-value="Unit Pengembangan Kompetensi">Unit Pengembangan Kompetensi</div>
                                    <div class="dropdown-search-item" data-value="Akademik">Akademik</div>
                                    <div class="dropdown-search-item" data-value="Kemahasiswaan">Kemahasiswaan</div>
                                    <div class="dropdown-search-item" data-value="Umum">Umum</div>
                                    <div class="dropdown-search-item" data-value="Keuangan dan BMN">Keuangan dan BMN</div>
                                    <div class="dropdown-search-item" data-value="Kepegawaian">Kepegawaian</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Keperawatan">Jurusan Keperawatan</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Kebidanan">Jurusan Kebidanan</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Kesehatan Gigi">Jurusan Kesehatan Gigi</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Gizi">Jurusan Gizi</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Kesehatan Lingkungan">Jurusan Kesehatan Lingkungan</div>
                                    <div class="dropdown-search-item" data-value="Jurusan Teknologi Laboratorium Medis">Jurusan Teknologi Laboratorium Medis</div>
                                    <div class="dropdown-search-item" data-value="Satuan Pengawas Internal">Satuan Pengawas Internal</div>
                                </div>
                                @error('unit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-key me-2"></i>Password Saat Ini
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="current_password" 
                                       value="{{ $user->password }}" 
                                       readonly>
                                <button class="btn btn-outline-secondary toggle-current-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Password yang sedang digunakan</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password baru">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pegawai
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nama:</strong><br>
                    <span class="text-dark">{{ $user->name }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>NIP:</strong><br>
                    <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ $user->nip }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Role:</strong><br>
                    <span class="badge bg-success">{{ ucfirst($user->role) }}</span>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <strong>Tanggal Dibuat:</strong><br>
                    <small class="text-muted">{{ $user->created_at->format('d F Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Terakhir Diupdate:</strong><br>
                    <small class="text-muted">{{ $user->updated_at->format('d F Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .dropdown-search-wrapper {
        position: relative;
    }
    
    .dropdown-search-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-top: 4px;
    }
    
    .dropdown-search-menu.show {
        display: block;
    }
    
    .dropdown-search-item {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .dropdown-search-item:last-child {
        border-bottom: none;
    }
    
    .dropdown-search-item:hover {
        background-color: #f8f9fa;
    }
    
    .dropdown-search-item.active {
        background-color: #e9ecef;
    }
    
    .dropdown-search-item.hidden {
        display: none;
    }
    
    .dropdown-search-input {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Searchable Unit Dropdown
        const searchInput = document.getElementById('unit-search');
        const hiddenInput = document.getElementById('unit');
        const dropdown = document.getElementById('unit-dropdown');
        const items = dropdown.querySelectorAll('.dropdown-search-item');
        
        // Load saved value if exists
        const savedValue = hiddenInput.value;
        if (savedValue) {
            searchInput.value = savedValue;
        }
        
        // Show dropdown on input focus
        searchInput.addEventListener('focus', function() {
            dropdown.classList.add('show');
            filterItems();
        });
        
        // Filter items on input
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value;
            hiddenInput.value = searchTerm; // Allow free text input
            filterItems();
        });
        
        // Select item on click
        items.forEach(function(item) {
            item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                searchInput.value = value;
                hiddenInput.value = value;
                dropdown.classList.remove('show');
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-search-wrapper')) {
                dropdown.classList.remove('show');
            }
        });
        
        // Filter function
        function filterItems() {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;
            
            items.forEach(function(item) {
                const itemText = item.textContent.toLowerCase();
                if (itemText.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
        }
        
        // Toggle current password visibility
        const toggleCurrentPasswordButton = document.querySelector('.toggle-current-password');
        if (toggleCurrentPasswordButton) {
            toggleCurrentPasswordButton.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
        
        // Toggle new password visibility
        const togglePasswordButton = document.querySelector('.toggle-password');
        if (togglePasswordButton) {
            togglePasswordButton.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const unit = hiddenInput.value;
                
                if (!unit) {
                    e.preventDefault();
                    alert('Unit wajib diisi.');
                    return false;
                }
                
                if (password && password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter.');
                    return false;
                }
            });
        }
    });
</script>
@endsection
