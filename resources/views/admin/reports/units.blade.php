@extends('layouts.admin')

@section('title', 'Data Unit - Laporan')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-1">
                    <i class="fas fa-building me-2"></i>Data Unit
                </h5>
                <p class="text-muted mb-0">Status optimasi dan data pegawai per unit</p>
            </div>
        </div>
    </div>
</div>

<!-- Sub Menu Navigation -->
<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.laporan.pegawai') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-1"></i>Data Pegawai
            </a>
            <a href="{{ route('admin.laporan.unit') }}" class="btn btn-primary">
                <i class="fas fa-building me-1"></i>Data Unit
            </a>
        </div>
    </div>
</div>

<!-- Filter Status Unit -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.unit') }}" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="unit_status" class="form-label">
                            <i class="fas fa-filter me-2"></i><strong>Filter Berdasarkan Status Unit</strong>
                        </label>
                        <select class="form-select" id="unit_status" name="unit_status">
                            <option value="">Semua Status</option>
                            <option value="optimal" {{ $selectedUnitStatus == 'optimal' ? 'selected' : '' }}>
                                🟢 Optimal (Semua Pegawai Optimal)
                            </option>
                            <option value="underload" {{ $selectedUnitStatus == 'underload' ? 'selected' : '' }}>
                                🟡 Kekurangan Beban Kerja (Ada yang Kurang)
                            </option>
                            <option value="overload" {{ $selectedUnitStatus == 'overload' ? 'selected' : '' }}>
                                🔴 Kelebihan Beban Kerja (Ada yang Lebih)
                            </option>
                            <option value="mixed" {{ $selectedUnitStatus == 'mixed' ? 'selected' : '' }}>
                                🟠 Kekurangan dan Kelebihan (Campuran)
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Terapkan Filter
                        </button>
                    </div>
                    
                    <div class="col-md-3">
                        <a href="{{ route('admin.laporan.unit') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-times me-1"></i>Reset Filter
                        </a>
                    </div>
                </form>
                
                @if($selectedUnitStatus)
                    <div class="mt-3">
                        <span class="badge bg-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Menampilkan unit dengan status: 
                            @if($selectedUnitStatus === 'optimal')
                                Optimal
                            @elseif($selectedUnitStatus === 'underload')
                                Kekurangan Beban Kerja
                            @elseif($selectedUnitStatus === 'overload')
                                Kelebihan Beban Kerja
                            @else
                                Kekurangan dan Kelebihan Beban Kerja
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Unit Status Cards -->
<div class="row mb-4">
    @foreach($unitOptimization as $unitName => $stats)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-building me-2"></i>{{ $unitName }}
                    </h6>
                    
                    <!-- Progress Bar -->
                    <div class="progress mb-3" style="height: 25px;">
                        <div class="progress-bar 
                            @if($stats['status'] === 'optimal') bg-success
                            @elseif($stats['status'] === 'overload') bg-danger
                            @elseif($stats['status'] === 'mixed') bg-info
                            @else bg-warning
                            @endif" 
                            role="progressbar" 
                            style="width: {{ $stats['optimal_percentage'] }}%">
                            {{ $stats['optimal_percentage'] }}%
                        </div>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row text-center mb-3">
                        <div class="col-3">
                            <div class="fw-bold text-primary">{{ $stats['total'] }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-success">{{ $stats['optimal'] }}</div>
                            <small class="text-muted">Optimal</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-warning">{{ $stats['underload'] }}</div>
                            <small class="text-muted">Kurang</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-danger">{{ $stats['overload'] }}</div>
                            <small class="text-muted">Lebih</small>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mb-3">
                        <span class="badge 
                            @if($stats['status'] === 'optimal') bg-success
                            @elseif($stats['status'] === 'overload') bg-danger
                            @elseif($stats['status'] === 'mixed') bg-info
                            @else bg-warning
                            @endif">
                            {{ $stats['status_label'] }}
                        </span>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('admin.laporan.unit.pegawai', ['unit' => urlencode($unitName)]) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-users me-1"></i>Lihat Pegawai
                        </a>
                        <a href="{{ route('admin.laporan.unit.pdf', $unitName) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-file-pdf me-1"></i>PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Info Box -->
<div class="row">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Petunjuk
                </h6>
                <ul class="mb-0">
                    <li>Klik <strong>"Lihat Pegawai"</strong> pada kartu unit untuk membuka halaman data pegawai unit tersebut</li>
                    <li>Gunakan <strong>"PDF"</strong> untuk download laporan lengkap unit</li>
                    <li>Progress bar menunjukkan persentase pegawai optimal dalam unit</li>
                    <li>Status unit: 
                        <span class="badge bg-success">🟢 Optimal</span> (semua optimal), 
                        <span class="badge bg-warning">🟡 Kekurangan</span> (ada yang kurang), 
                        <span class="badge bg-danger">🔴 Kelebihan</span> (ada yang lebih),
                        <span class="badge bg-info">🟠 Campuran</span> (ada kurang & lebih)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

