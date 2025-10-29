@extends('layouts.admin')

@section('title', 'Tambah Akun Pegawai')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-user-plus me-2"></i>Tambah Akun Pegawai Baru
                        </h5>
                        <p class="text-muted mb-0">Tambahkan akun pegawai baru ke dalam sistem</p>
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
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Tambah Pegawai
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kelola-akun') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                   value="{{ old('nip') }}" 
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
                                   value="{{ old('email') }}" 
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
                                   value="{{ old('position') }}" 
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
                                       value="{{ old('unit') }}" 
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
                        <div class="col-md-12 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-user-plus me-2"></i>Simpan Pegawai
                                </button>
                                <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
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
    // Toggle password visibility - Simple function
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    
    $(document).ready(function() {
        
        // Searchable Unit Dropdown
        const searchInput = $('#unit-search');
        const hiddenInput = $('#unit');
        const dropdown = $('#unit-dropdown');
        const items = dropdown.find('.dropdown-search-item');
        
        // Load saved value if exists
        const savedValue = hiddenInput.val();
        if (savedValue) {
            searchInput.val(savedValue);
        }
        
        // Show dropdown on input focus
        searchInput.on('focus', function() {
            dropdown.addClass('show');
            filterItems();
        });
        
        // Filter items on input
        searchInput.on('input', function() {
            const searchTerm = $(this).val();
            hiddenInput.val(searchTerm); // Allow free text input
            filterItems();
        });
        
        // Select item on click
        items.on('click', function() {
            const value = $(this).data('value');
            searchInput.val(value);
            hiddenInput.val(value);
            dropdown.removeClass('show');
        });
        
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown-search-wrapper').length) {
                dropdown.removeClass('show');
            }
        });
        
        // Filter function
        function filterItems() {
            const searchTerm = searchInput.val().toLowerCase();
            let visibleCount = 0;
            
            items.each(function() {
                const itemText = $(this).text().toLowerCase();
                if (itemText.includes(searchTerm)) {
                    $(this).removeClass('hidden');
                    visibleCount++;
                } else {
                    $(this).addClass('hidden');
                }
            });
            
            // Show message if no results
            if (visibleCount === 0 && searchTerm) {
                // You can add a "no results" message here if needed
            }
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        const password = $('#password').val();
        const unit = $('#unit').val();
        
        if (!unit) {
            alert('Unit wajib diisi.');
            e.preventDefault();
            return false;
        }
        
        if (password.length < 6) {
            alert('Password minimal 6 karakter.');
            e.preventDefault();
            return false;
        }
    });
</script>
@endsection
