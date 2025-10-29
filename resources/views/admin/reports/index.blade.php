@extends('layouts.admin')

@section('title', 'Sistem & Laporan')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-1">
                    <i class="fas fa-chart-line me-2"></i>Sistem & Laporan
                </h5>
                <p class="text-muted mb-0">Laporan dan analisis beban kerja pegawai berdasarkan unit</p>
            </div>
        </div>
    </div>
</div>

<!-- Unit Optimization Overview -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i>Status Optimasi Unit
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($unitOptimization as $unitName => $stats)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ $unitName }}</h6>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar 
                                            @if($stats['status'] === 'optimal') bg-success
                                            @elseif($stats['status'] === 'overload') bg-danger
                                            @else bg-warning
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ $stats['optimal_percentage'] }}%"
                                            aria-valuenow="{{ $stats['optimal_percentage'] }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ $stats['optimal_percentage'] }}%
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        Total: {{ $stats['total'] }} | 
                                        Optimal: {{ $stats['optimal'] }} | 
                                        Kurang: {{ $stats['underload'] }} | 
                                        Lebih: {{ $stats['overload'] }}
                                    </small>
                                    <div class="mt-2">
                                        <span class="badge 
                                            @if($stats['status'] === 'optimal') bg-success
                                            @elseif($stats['status'] === 'overload') bg-danger
                                            @else bg-warning
                                            @endif">
                                            {{ $stats['status_label'] }}
                                        </span>
                                        <a href="{{ route('admin.laporan.unit.pdf', $unitName) }}" 
                                           class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">
                            <i class="fas fa-search me-1"></i>Cari NIP
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Masukkan NIP...">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="unit" class="form-label">
                            <i class="fas fa-building me-1"></i>Filter Unit
                        </label>
                        <select class="form-select" id="unit" name="unit">
                            <option value="">Semua Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-filter me-1"></i>Filter Status
                        </label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="optimal" {{ request('status') == 'optimal' ? 'selected' : '' }}>Optimal</option>
                            <option value="underload" {{ request('status') == 'underload' ? 'selected' : '' }}>Kekurangan Beban</option>
                            <option value="overload" {{ request('status') == 'overload' ? 'selected' : '' }}>Kelebihan Beban</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.laporan') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Download Reports by Status -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-download me-2"></i>Download Laporan Berdasarkan Status
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h6>Pegawai Optimal</h6>
                            <p class="text-muted small">Download laporan seluruh pegawai dengan beban kerja optimal</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'optimal') }}" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                            <h6>Pegawai Kekurangan Beban</h6>
                            <p class="text-muted small">Download laporan pegawai dengan beban kerja kurang dari optimal</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'underload') }}" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h6>Pegawai Kelebihan Beban</h6>
                            <p class="text-muted small">Download laporan pegawai dengan beban kerja berlebih</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'overload') }}" 
                               class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employee Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>Data Pegawai
                    <span class="badge bg-primary ms-2">{{ $employeesData->count() }} Pegawai</span>
                </h5>
            </div>
            <div class="card-body">
                @if($employeesData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Unit</th>
                                    <th>Beban Kerja (Menit/Hari)</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeesData as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data['user']->name }}</td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                                                {{ $data['user']->nip }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $data['user']->unit ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($data['total_minutes'], 1) }}</strong> menit
                                            @php
                                                $effectiveWorkTime = 300;
                                                $difference = $data['total_minutes'] - $effectiveWorkTime;
                                            @endphp
                                            @if($difference != 0)
                                                <br>
                                                <small class="text-muted">
                                                    ({{ $difference > 0 ? '+' : '' }}{{ number_format($difference, 1) }} dari target 300 menit)
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data['status'] === 'optimal')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Optimal
                                                </span>
                                            @elseif($data['status'] === 'overload')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Kelebihan
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-arrow-down me-1"></i>Kekurangan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.laporan.pegawai.pdf', $data['user']->nip) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Download PDF Pegawai">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data pegawai</h5>
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form on filter change (optional)
    $('#unit, #status').on('change', function() {
        // Uncomment to enable auto-submit
        // $(this).closest('form').submit();
    });
</script>
@endsection

