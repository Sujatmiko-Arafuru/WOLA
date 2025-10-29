@extends('layouts.pegawai')

@section('title', 'Edit Beban Kerja')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Entri Beban Kerja
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pegawai.update-beban-kerja', $workloadEntry->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Mengedit entri akan mencatat perubahan dan admin akan mendapat notifikasi.
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="task_id" class="form-label">
                                <i class="fas fa-tasks me-2"></i>Uraian Tugas
                            </label>
                            <select class="form-control @error('task_id') is-invalid @enderror" 
                                    id="task_id" 
                                    name="task_id" 
                                    required>
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}" 
                                            {{ $workloadEntry->task_id == $task->id ? 'selected' : '' }}>
                                        {{ $task->task_description }} ({{ $task->time_per_unit }} menit/unit)
                                    </option>
                                @endforeach
                            </select>
                            @error('task_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">
                                <i class="fas fa-hashtag me-2"></i>Jumlah
                            </label>
                            <input type="number" 
                                   class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="{{ old('quantity', $workloadEntry->quantity) }}" 
                                   min="1"
                                   placeholder="Masukkan jumlah"
                                   required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="time_unit" class="form-label">
                                <i class="fas fa-clock me-2"></i>Satuan Waktu
                            </label>
                            <select class="form-control @error('time_unit') is-invalid @enderror" 
                                    id="time_unit" 
                                    name="time_unit" 
                                    required>
                                <option value="daily" {{ old('time_unit', $workloadEntry->time_unit) == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ old('time_unit', $workloadEntry->time_unit) == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ old('time_unit', $workloadEntry->time_unit) == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ old('time_unit', $workloadEntry->time_unit) == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                            @error('time_unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="reason" class="form-label">
                                <i class="fas fa-comment me-2"></i>Alasan Pengeditan
                            </label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" 
                                      name="reason" 
                                      rows="3"
                                      placeholder="Jelaskan alasan mengapa Anda mengedit entri ini..."
                                      required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('pegawai.beban-kerja') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Current Entry Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Entri Saat Ini
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Uraian Tugas:</strong><br>
                        {{ $workloadEntry->task->task_description }}
                    </div>
                    <div class="col-md-2">
                        <strong>Jumlah:</strong><br>
                        {{ $workloadEntry->quantity }}
                    </div>
                    <div class="col-md-2">
                        <strong>Satuan:</strong><br>
                        @switch($workloadEntry->time_unit)
                            @case('daily')
                                <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">Harian</span>
                                @break
                            @case('weekly')
                                <span class="badge" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">Mingguan</span>
                                @break
                            @case('monthly')
                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Bulanan</span>
                                @break
                            @case('yearly')
                                <span class="badge" style="background: linear-gradient(135deg, #1e5f5f, #2d8f8f);">Tahunan</span>
                                @break
                        @endswitch
                    </div>
                    <div class="col-md-2">
                        <strong>Total Menit:</strong><br>
                        {{ number_format($workloadEntry->total_minutes) }}
                    </div>
                    <div class="col-md-2">
                        <strong>Edit Ke-:</strong><br>
                        @if($workloadEntry->edit_count > 0)
                            <span class="badge" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">{{ $workloadEntry->edit_count }}</span>
                        @else
                            <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Original</span>
                        @endif
                    </div>
                    <div class="col-md-1">
                        <strong>Tanggal:</strong><br>
                        {{ $workloadEntry->created_at->format('d/m/Y') }}
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
        const taskSelect = document.getElementById('task_id');
        const quantityInput = document.getElementById('quantity');
        const timeUnitSelect = document.getElementById('time_unit');
        
        // Function to calculate and show preview
        function calculateAndShowPreview() {
            const taskId = taskSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;
            const timeUnit = timeUnitSelect.value;
            
            if (taskId && quantity && timeUnit) {
                // Get task time per unit from selected option
                const selectedOption = taskSelect.options[taskSelect.selectedIndex];
                const timePerUnit = parseInt(selectedOption.text.match(/\((\d+) menit\/unit\)/)?.[1] || 0);
                
                if (timePerUnit > 0) {
                    // Calculate minutes per day using new formula
                    let minutesPerDay = timePerUnit * quantity;
                    switch (timeUnit) {
                        case 'weekly':
                            minutesPerDay = minutesPerDay / 5;
                            break;
                        case 'monthly':
                            minutesPerDay = minutesPerDay / 20;
                            break;
                        case 'yearly':
                            minutesPerDay = minutesPerDay / 240;
                            break;
                    }
                    
                    // Show preview
                    let previewDiv = document.getElementById('preview');
                    if (!previewDiv) {
                        previewDiv = document.createElement('div');
                        previewDiv.id = 'preview';
                        previewDiv.className = 'alert alert-info mt-3';
                        document.querySelector('.card-body').appendChild(previewDiv);
                    }
                    
                    previewDiv.innerHTML = `
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Preview Perubahan:</strong><br>
                        Waktu (menit): <strong>${(timePerUnit * quantity).toLocaleString()} menit</strong><br>
                        Menit kerja per hari: <strong>${minutesPerDay.toFixed(1)} menit</strong>
                    `;
                }
            } else {
                // Clear preview
                const previewDiv = document.getElementById('preview');
                if (previewDiv) {
                    previewDiv.remove();
                }
            }
        }
        
        // Event listeners
        taskSelect.addEventListener('change', calculateAndShowPreview);
        quantityInput.addEventListener('input', calculateAndShowPreview);
        timeUnitSelect.addEventListener('change', calculateAndShowPreview);
    });
</script>
@endsection
