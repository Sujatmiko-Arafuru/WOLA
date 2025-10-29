@extends('layouts.admin')

@section('title', 'Data Pegawai - Laporan')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-1">
                    <i class="fas fa-users me-2"></i>Data Pegawai
                </h5>
                <p class="text-muted mb-0">Data lengkap beban kerja seluruh pegawai</p>
            </div>
        </div>
    </div>
</div>

<!-- Sub Menu Navigation -->
<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.laporan.pegawai') }}" class="btn btn-primary">
                <i class="fas fa-users me-1"></i>Data Pegawai
            </a>
            <a href="{{ route('admin.laporan.unit') }}" class="btn btn-outline-primary">
                <i class="fas fa-building me-1"></i>Data Unit
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.pegawai') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">
                            <i class="fas fa-search me-1"></i>Cari Nama atau NIP
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Masukkan nama atau NIP...">
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
                    
                    <div class="col-md-3">
                        <label for="sort" class="form-label">
                            <i class="fas fa-sort me-1"></i>Urutkan Beban Kerja
                        </label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="">Urutkan Nama (A-Z)</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terkecil ke Terbesar</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbesar ke Terkecil</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.laporan.pegawai') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Summary -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $paginator->total() }}</h3>
                <p class="mb-0 text-muted">Total Pegawai</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="text-success">{{ collect($paginator->items())->where('status', 'optimal')->count() }}</h3>
                <p class="mb-0 text-muted">Optimal (Halaman Ini)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="text-warning">{{ collect($paginator->items())->where('status', 'underload')->count() }}</h3>
                <p class="mb-0 text-muted">Kekurangan (Halaman Ini)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="text-danger">{{ collect($paginator->items())->where('status', 'overload')->count() }}</h3>
                <p class="mb-0 text-muted">Kelebihan (Halaman Ini)</p>
            </div>
        </div>
    </div>
</div>

<!-- Employee Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>Data Pegawai
                    <span class="badge bg-primary ms-2">{{ $employeesData->count() }} Pegawai</span>
                </h5>
                @if(request()->hasAny(['search', 'status', 'sort']))
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>Menampilkan hasil filter
                    </small>
                @endif
            </div>
            <div class="card-body">
                @if($employeesData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th style="width: 15%;">NIP</th>
                                    <th style="width: 15%;">Unit</th>
                                    <th style="width: 15%;">Beban Kerja</th>
                                    <th style="width: 10%;">Selisih</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeesData as $index => $data)
                                    <tr>
                                        <td>{{ $paginator->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $data['user']->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $data['user']->position }}</small>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                                                {{ $data['user']->nip }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $data['user']->unit ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($data['total_minutes'], 1) }}</strong> menit/hari
                                        </td>
                                        <td>
                                            @php
                                                $effectiveWorkTime = 300;
                                                $difference = $data['total_minutes'] - $effectiveWorkTime;
                                                $diffColor = $difference > 0 ? 'danger' : ($difference < 0 ? 'warning' : 'success');
                                            @endphp
                                            <span class="text-{{ $diffColor }}">
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
                            <tfoot>
                                <tr class="table-secondary">
                                    <th colspan="4" class="text-end">Rata-rata Beban Kerja (Halaman Ini):</th>
                                    <th>
                                        <strong>{{ number_format($employeesData->avg('total_minutes'), 1) }}</strong> menit/hari
                                    </th>
                                    <th colspan="3"></th>
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
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data pegawai</h5>
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('admin.laporan.pegawai') }}" class="btn btn-primary">
                            <i class="fas fa-redo me-1"></i>Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Download Options -->
@if($employeesData->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-download me-2"></i>Download Laporan (Semua Data)
                </h5>
                <p class="text-muted mb-0 small">Download PDF berisi semua pegawai sesuai status, bukan hanya yang ditampilkan di halaman ini</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h6>Pegawai Optimal</h6>
                            <p class="text-muted small mb-2">
                                <strong class="h5 text-success">{{ $allEmployeesData->where('status', 'optimal')->count() }}</strong> pegawai
                            </p>
                            <p class="text-muted small mb-3">Download semua pegawai dengan status optimal</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'optimal') }}" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                            <h6>Pegawai Kekurangan</h6>
                            <p class="text-muted small mb-2">
                                <strong class="h5 text-warning">{{ $allEmployeesData->where('status', 'underload')->count() }}</strong> pegawai
                            </p>
                            <p class="text-muted small mb-3">Download semua pegawai dengan beban kerja kurang</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'underload') }}" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h6>Pegawai Kelebihan</h6>
                            <p class="text-muted small mb-2">
                                <strong class="h5 text-danger">{{ $allEmployeesData->where('status', 'overload')->count() }}</strong> pegawai
                            </p>
                            <p class="text-muted small mb-3">Download semua pegawai dengan beban kerja berlebih</p>
                            <a href="{{ route('admin.laporan.status.pdf', 'overload') }}" 
                               class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi:</strong> PDF yang didownload berisi <strong>SEMUA pegawai</strong> dengan status terpilih dari database, 
                    bukan hanya yang ditampilkan di halaman ini ({{ $employeesData->count() }} dari {{ $allEmployeesData->count() }} total pegawai).
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
