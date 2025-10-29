@extends('layouts.admin')

@section('title', 'Tambah Tugas')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-plus me-2"></i>Tambah Tugas Baru
                        </h5>
                        <p class="text-muted mb-0">Tambahkan uraian tugas baru ke dalam sistem</p>
                    </div>
                    <a href="{{ route('admin.kelola-tugas') }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Form Tambah Tugas
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kelola-tugas') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="task_description" class="form-label">
                            <i class="fas fa-tasks me-2"></i>Uraian Tugas
                        </label>
                        <input type="text" 
                               class="form-control @error('task_description') is-invalid @enderror" 
                               id="task_description" 
                               name="task_description" 
                               value="{{ old('task_description') }}" 
                               placeholder="Masukkan uraian tugas"
                               required>
                        @error('task_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Contoh: Membuat surat keluar, Melakukan penelitian, dll.</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="time_per_unit" class="form-label">
                            <i class="fas fa-clock me-2"></i>Waktu per Unit (Menit)
                        </label>
                        <input type="number" 
                               class="form-control @error('time_per_unit') is-invalid @enderror" 
                               id="time_per_unit" 
                               name="time_per_unit" 
                               value="{{ old('time_per_unit') }}" 
                               min="1"
                               placeholder="Masukkan waktu dalam menit"
                               required>
                        @error('time_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Waktu yang dibutuhkan untuk menyelesaikan 1 unit tugas dalam menit.</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Tugas
                        </button>
                        <a href="{{ route('admin.kelola-tugas') }}" class="btn btn-secondary">
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
                    <i class="fas fa-info-circle me-2"></i>Informasi
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Tips Menentukan Waktu:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Surat keluar: 30 menit</li>
                        <li><i class="fas fa-check text-success me-2"></i>Laporan bulanan: 120 menit</li>
                        <li><i class="fas fa-check text-success me-2"></i>Evaluasi pembelajaran: 240 menit</li>
                        <li><i class="fas fa-check text-success me-2"></i>Laporan tahunan: 300 menit</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>Konversi Waktu:</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-clock text-info me-2"></i>1 Minggu = 5 Hari</li>
                        <li><i class="fas fa-clock text-info me-2"></i>1 Bulan = 4 Minggu</li>
                        <li><i class="fas fa-clock text-info me-2"></i>1 Tahun = 12 Bulan</li>
                    </ul>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Tips:</strong> Tugas yang ditambahkan akan langsung aktif dan dapat digunakan oleh pegawai.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation
    $('form').on('submit', function() {
        const taskDescription = $('#task_description').val().trim();
        const timePerUnit = parseInt($('#time_per_unit').val());
        
        if (!taskDescription) {
            alert('Uraian tugas wajib diisi.');
            return false;
        }
        
        if (!timePerUnit || timePerUnit < 1) {
            alert('Waktu per unit minimal 1 menit.');
            return false;
        }
    });
</script>
@endsection
