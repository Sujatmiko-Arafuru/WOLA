@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Welcome Card -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card admin-card">
            <div class="card-body text-center">
                <h2 class="mb-2">
                    <i class="fas fa-user-shield me-2"></i>Selamat Datang, Admin!
                </h2>
                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Simplified Statistics (Compact) -->
<div class="row mb-3">
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center py-4">
                <i class="fas fa-users fa-lg mb-2"></i>
                <div class="stats-number" style="font-size: 1.75rem;">{{ $totalEmployees }}</div>
                <p class="mb-0">Total Pegawai</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center py-4">
                <i class="fas fa-tasks fa-lg mb-2"></i>
                <div class="stats-number" style="font-size: 1.75rem;">{{ $totalTasks }}</div>
                <p class="mb-0">Total Tugas</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center py-4">
                <i class="fas fa-bell fa-lg mb-2"></i>
                <div class="stats-number" style="font-size: 1.75rem;">{{ $unreadNotifications }}</div>
                <p class="mb-0">Notifikasi Belum Dibaca</p>
            </div>
        </div>
    </div>
</div>
<!-- Recent Entries -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Entri Terbaru
                </h5>
                <a href="{{ route('admin.kelola-akun') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua Pegawai
                </a>
            </div>
            <div class="card-body">
                @if($recentEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pegawai</th>
                                    <th>Uraian Tugas</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Total Menit</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEntries as $index => $entry)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $entry->user->name }}</td>
                                        <td>{{ $entry->task->task_description }}</td>
                                        <td>{{ $entry->quantity }}</td>
                                        <td>
                                            @switch($entry->time_unit)
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
                                        </td>
                                        <td>{{ number_format($entry->total_minutes) }} menit</td>
                                        <td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada entri beban kerja</h5>
                        <p class="text-muted">Pegawai belum melakukan input beban kerja.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script></script>
@endsection
