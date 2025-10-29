@extends('layouts.admin')

@section('title', 'Detail Akun Pegawai')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-user me-2"></i>Detail Akun Pegawai
                        </h5>
                        <p class="text-muted mb-0">Informasi lengkap pegawai</p>
                    </div>
                    <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Info -->
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Pegawai
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama:</strong><br>
                        <span class="text-dark">{{ $user->name }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>NIP:</strong><br>
                        <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ $user->nip }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Email:</strong><br>
                        <span class="text-dark">{{ $user->email }}</span>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jabatan:</strong><br>
                        <span class="text-dark">{{ $user->position }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Unit:</strong><br>
                        <span class="badge bg-primary">{{ $user->unit ?? 'Tidak ada unit' }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Tanggal Dibuat:</strong><br>
                        <span class="text-dark">{{ $user->created_at->format('d F Y H:i') }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Password:</strong><br>
                        <div class="input-group" style="max-width: 250px;">
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password_display" 
                                   value="••••••••" 
                                   readonly
                                   style="font-family: monospace;">
                            <button class="btn btn-outline-secondary btn-sm toggle-current-password-display" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Klik ikon mata untuk melihat password</small>
                    </div>
                    <div class="col-md-4">
                        <strong>Terakhir Diupdate:</strong><br>
                        <span class="text-dark">{{ $user->updated_at->format('d F Y H:i') }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Role:</strong><br>
                        <span class="badge bg-success">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle current password visibility in detail view
        const toggleCurrentPasswordDisplayButton = document.querySelector('.toggle-current-password-display');
        if (toggleCurrentPasswordDisplayButton) {
            toggleCurrentPasswordDisplayButton.addEventListener('click', function() {
                const input = document.getElementById('current_password_display');
                const icon = this.querySelector('i');
                
                if (input.value === '••••••••') {
                    // Show actual password
                    fetch(`/admin/kelola-akun/{{ $user->id }}/password`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            input.value = data.password;
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        })
                        .catch(error => {
                            console.error('Error fetching password:', error);
                            alert('Gagal mengambil password. Silakan coba lagi.');
                        });
                } else {
                    // Hide password
                    input.value = '••••••••';
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    });
</script>
@endsection
