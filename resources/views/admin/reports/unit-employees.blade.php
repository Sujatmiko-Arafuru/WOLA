@extends('layouts.admin')

@section('title', 'Data Pegawai - ' . $unitName)

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-users me-2"></i>Data Pegawai - {{ $unitName }}
                        </h5>
                        <p class="text-muted mb-0">Daftar pegawai dan beban kerja per unit</p>
                    </div>
                    <a href="{{ route('admin.laporan.unit') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Data Unit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.unit.pegawai', ['unit' => urlencode($unitName)]) }}" class="row g-3">
                    <div class="col-md-5">
                        <label for="status" class="form-label">
                            <i class="fas fa-filter me-1"></i><strong>Filter Status Pegawai</strong>
                        </label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="optimal" {{ $selectedEmployeeStatus == 'optimal' ? 'selected' : '' }}>
                                ✅ Optimal
                            </option>
                            <option value="underload" {{ $selectedEmployeeStatus == 'underload' ? 'selected' : '' }}>
                                ⚠️ Kekurangan Beban Kerja
                            </option>
                            <option value="overload" {{ $selectedEmployeeStatus == 'overload' ? 'selected' : '' }}>
                                🔴 Kelebihan Beban Kerja
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="sort" class="form-label">
                            <i class="fas fa-sort me-1"></i><strong>Urutkan Beban Kerja</strong>
                        </label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="">Urutkan Nama (Default)</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terkecil ke Terbesar</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbesar ke Terkecil</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.laporan.unit.pegawai', ['unit' => urlencode($unitName)]) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Info Alert -->
@if($employeesData->count() > 0)
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Menampilkan <strong>{{ $employeesData->count() }}</strong> pegawai
            dari unit <strong>{{ $unitName }}</strong>
            @if($selectedEmployeeStatus)
                dengan status 
                <strong>
                    @if($selectedEmployeeStatus === 'optimal')
                        Optimal
                    @elseif($selectedEmployeeStatus === 'overload')
                        Kelebihan Beban Kerja
                    @else
                        Kekurangan Beban Kerja
                    @endif
                </strong>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Employee Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($employeesData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th style="width: 15%;">NIP</th>
                                    <th style="width: 15%;">Unit</th>
                                    <th style="width: 15%;">Jabatan</th>
                                    <th style="width: 12%;">Beban Kerja</th>
                                    <th style="width: 10%;">Selisih</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 8%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeesData as $index => $data)
                                    <tr>
                                        <td>{{ $paginator->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $data['user']->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                                                {{ $data['user']->nip }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $data['user']->unit }}</span>
                                        </td>
                                        <td>{{ $data['user']->position }}</td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($data['total_minutes'], 1) }}</strong>
                                            <small class="text-muted">menit/hari</small>
                                        </td>
                                        <td>
                                            @php
                                                $effectiveWorkTime = 300;
                                                $difference = $data['total_minutes'] - $effectiveWorkTime;
                                                $diffColor = $difference > 0 ? 'danger' : ($difference < 0 ? 'warning' : 'success');
                                            @endphp
                                            <span class="text-{{ $diffColor }} fw-bold">
                                                {{ $difference > 0 ? '+' : '' }}{{ number_format($difference, 1) }}
                                            </span>
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
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.laporan.pegawai.detail', $data['user']->nip) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail Beban Kerja">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <a href="{{ route('admin.laporan.pegawai.pdf', $data['user']->nip) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Download PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5" class="text-end">Rata-rata Beban Kerja (Halaman Ini):</th>
                                    <th colspan="2">
                                        <strong class="text-primary">{{ number_format($employeesData->avg('total_minutes'), 1) }}</strong>
                                        <small class="text-muted">menit/hari</small>
                                    </th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} pegawai
                        </div>
                        <div>
                            {{ $paginator->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Data Pegawai</h5>
                        <p class="text-muted mb-4">
                            Tidak ada pegawai di unit <strong>{{ $unitName }}</strong>
                            @if($selectedEmployeeStatus)
                                dengan status 
                                <strong>
                                    @if($selectedEmployeeStatus === 'optimal')
                                        Optimal
                                    @elseif($selectedEmployeeStatus === 'overload')
                                        Kelebihan Beban Kerja
                                    @else
                                        Kekurangan Beban Kerja
                                    @endif
                                </strong>
                            @endif
                        </p>
                        @if($selectedEmployeeStatus)
                            <a href="{{ route('admin.laporan.unit.pegawai', ['unit' => urlencode($unitName)]) }}" class="btn btn-primary">
                                <i class="fas fa-redo me-1"></i>Lihat Semua Status
                            </a>
                        @else
                            <a href="{{ route('admin.laporan.unit') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Data Unit
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
@if($employeesData->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">
                            <i class="fas fa-download me-2"></i>Download Laporan
                        </h6>
                        <small class="text-muted">Download laporan unit dalam format PDF</small>
                    </div>
                    <a href="{{ route('admin.laporan.unit.pdf', urlencode($unitName)) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF Unit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
