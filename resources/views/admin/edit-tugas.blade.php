@extends('layouts.admin')

@section('title', 'Edit Tugas')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-edit me-2"></i>Edit Tugas
                        </h5>
                        <p class="text-muted mb-0">Edit informasi tugas yang sudah ada</p>
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
                    <i class="fas fa-edit me-2"></i>Form Edit Tugas
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kelola-tugas', $task) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="task_description" class="form-label">
                            <i class="fas fa-tasks me-2"></i>Uraian Tugas
                        </label>
                        <input type="text" 
                               class="form-control @error('task_description') is-invalid @enderror" 
                               id="task_description" 
                               name="task_description" 
                               value="{{ old('task_description', $task->task_description) }}" 
                               placeholder="Masukkan uraian tugas"
                               required>
                        @error('task_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="time_per_unit" class="form-label">
                            <i class="fas fa-clock me-2"></i>Waktu per Unit (Menit)
                        </label>
                        <input type="number" 
                               class="form-control @error('time_per_unit') is-invalid @enderror" 
                               id="time_per_unit" 
                               name="time_per_unit" 
                               value="{{ old('time_per_unit', $task->time_per_unit) }}" 
                               min="1"
                               placeholder="Masukkan waktu dalam menit"
                               required>
                        @error('time_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   {{ old('is_active', $task->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-toggle-on me-2"></i>Tugas Aktif
                            </label>
                        </div>
                        <div class="form-text">Centang untuk mengaktifkan tugas, kosongkan untuk menonaktifkan.</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
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
                    <i class="fas fa-info-circle me-2"></i>Informasi Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status Saat Ini:</strong><br>
                    @if($task->is_active)
                        <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Aktif</span>
                    @else
                        <span class="badge" style="background: linear-gradient(135deg, #6c757d, #495057);">Nonaktif</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <strong>Total Digunakan:</strong><br>
                    <span class="badge" style="background: linear-gradient(135deg, #1e5f5f, #2d8f8f);">{{ $task->workloadEntries->count() }} kali</span>
                </div>
                
                <div class="mb-3">
                    <strong>Tanggal Dibuat:</strong><br>
                    {{ $task->created_at->format('d F Y H:i') }}
                </div>
                
                <div class="mb-3">
                    <strong>Terakhir Diupdate:</strong><br>
                    {{ $task->updated_at->format('d F Y H:i') }}
                </div>
                
                @if($task->workloadEntries->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Tugas ini sudah digunakan dalam {{ $task->workloadEntries->count() }} entri beban kerja.
                    </div>
                @endif
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
