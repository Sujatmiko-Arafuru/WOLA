@extends('layouts.admin')

@section('title', 'Detail Perubahan')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-history me-2"></i>Detail Perubahan
                        </h5>
                        <p class="text-muted mb-0">Informasi lengkap perubahan yang dilakukan pegawai</p>
                    </div>
                    <a href="{{ route('admin.notifikasi-perubahan') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reason - Most Important -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-comment me-2"></i>Alasan Perubahan
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-primary mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>{{ $editLog->reason ?: 'Tidak ada alasan yang diberikan' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Details -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Pegawai
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <strong>Nama:</strong><br>
                        {{ $editLog->user->name }}
                    </div>
                    <div class="col-6">
                        <strong>NIP:</strong><br>
                        <span class="badge bg-info">{{ $editLog->user->nip }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <strong>Email:</strong><br>
                        {{ $editLog->user->email }}
                    </div>
                    <div class="col-6">
                        <strong>Jabatan:</strong><br>
                        {{ $editLog->user->position }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Informasi Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Uraian Tugas:</strong><br>
                    {{ $editLog->workloadEntry->task->task_description }}
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong>Waktu per Unit:</strong><br>
                        <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ $editLog->workloadEntry->task->time_per_unit }} menit</span>
                    </div>
                    <div class="col-6">
                        <strong>Edit Ke-:</strong><br>
                        <span class="badge" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">{{ $editLog->edit_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Comparison -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Perbandingan Perubahan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-arrow-left me-2"></i>Data Lama
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Jumlah:</strong><br>
                                        {{ $editLog->old_quantity }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Satuan:</strong><br>
                                        @switch($editLog->old_time_unit)
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
                                </div>
                                <hr>
                                <div class="text-center">
                                    <strong>Total Menit:</strong><br>
                                    <span class="text-danger fs-4">{{ number_format($editLog->old_total_minutes) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-arrow-right me-2"></i>Data Baru
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Jumlah:</strong><br>
                                        {{ $editLog->new_quantity }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Satuan:</strong><br>
                                        @switch($editLog->new_time_unit)
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
                                </div>
                                <hr>
                                <div class="text-center">
                                    <strong>Total Menit:</strong><br>
                                    <span class="text-success fs-4">{{ number_format($editLog->new_total_minutes) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Difference -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="mb-3">Selisih Perubahan</h6>
                                @php
                                    $difference = $editLog->new_total_minutes - $editLog->old_total_minutes;
                                @endphp
                                @if($difference > 0)
                                    <span class="text-success fs-3">
                                        <i class="fas fa-arrow-up me-2"></i>+{{ number_format($difference) }} menit
                                    </span>
                                    <p class="text-muted mt-2">Beban kerja bertambah</p>
                                @elseif($difference < 0)
                                    <span class="text-danger fs-3">
                                        <i class="fas fa-arrow-down me-2"></i>{{ number_format($difference) }} menit
                                    </span>
                                    <p class="text-muted mt-2">Beban kerja berkurang</p>
                                @else
                                    <span class="text-info fs-3">
                                        <i class="fas fa-equals me-2"></i>Tidak ada perubahan
                                    </span>
                                    <p class="text-muted mt-2">Total menit tetap sama</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tanggal Perubahan:</strong><br>
                        {{ $editLog->created_at->format('d F Y H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status Notifikasi:</strong><br>
                        @if($editLog->admin_notified)
                            <span class="badge bg-success">Sudah Dibaca</span>
                        @else
                            <span class="badge bg-danger">Belum Dibaca</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
