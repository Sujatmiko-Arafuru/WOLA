@extends('layouts.admin')

@section('title', 'Kelola Akun')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-users me-2"></i>Kelola Akun Pegawai
                        </h5>
                        <p class="text-muted mb-0">Kelola data akun pegawai dalam sistem</p>
                    </div>
                    <a href="{{ route('admin.tambah-akun') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Pegawai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.kelola-akun') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label for="search" class="form-label">
                                <i class="fas fa-search me-2"></i>Cari Pegawai
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Cari berdasarkan Nama atau NIP..."
                                   value="{{ $search ?? '' }}">
                            <small class="text-muted">Ketik nama atau NIP pegawai yang ingin dicari</small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            @if($search)
                                <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary w-100 mt-2">
                                    <i class="fas fa-times me-2"></i>Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($search)
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Hasil pencarian untuk: <strong>"{{ $search }}"</strong> 
                        - Ditemukan <strong>{{ $users->total() }}</strong> pegawai
                    </div>
                @endif
                
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>Unit</th>
                                    <th>Menit per hari</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ $user->nip }}</span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $user->unit ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
                                                    return $entry->calculateMinutesPerDay();
                                                });
                                            @endphp
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ number_format($totalMinutesPerDay, 1) }} menit</span>
                                        </td>
                                        <td>
                                            @php
                                                $effectiveWorkTime = 300; // 5 jam = 300 menit
                                                if ($totalMinutesPerDay >= $effectiveWorkTime - 10 && $totalMinutesPerDay <= $effectiveWorkTime + 10) {
                                                    $status = 'optimal';
                                                    $statusLabel = 'Optimal';
                                                    $statusColor = 'linear-gradient(135deg, #27ae60, #2ecc71)';
                                                } elseif ($totalMinutesPerDay > $effectiveWorkTime + 10) {
                                                    $status = 'overload';
                                                    $statusLabel = 'Berlebih';
                                                    $statusColor = 'linear-gradient(135deg, #e74c3c, #c0392b)';
                                                } else {
                                                    $status = 'underload';
                                                    $statusLabel = 'Kurang';
                                                    $statusColor = 'linear-gradient(135deg, #f1c40f, #f39c12)';
                                                }
                                            @endphp
                                            <span class="badge" style="background: {{ $statusColor }};">{{ $statusLabel }}</span>
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.detail-akun', $user) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.edit-akun', $user) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('admin.kelola-akun', $user) }}" 
                                                      class="d-inline btn-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pegawai
                        </div>
                        <div>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        @if($search)
                            <i class="fas fa-search fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada hasil pencarian</h5>
                            <p class="text-muted">Tidak ditemukan pegawai dengan kata kunci "<strong>{{ $search }}</strong>"</p>
                            <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pegawai
                            </a>
                        @else
                            <i class="fas fa-users fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pegawai</h5>
                            <p class="text-muted">Mulai dengan menambahkan pegawai pertama.</p>
                            <a href="{{ route('admin.tambah-akun') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Pegawai Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection