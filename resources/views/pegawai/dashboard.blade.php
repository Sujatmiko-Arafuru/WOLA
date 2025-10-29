@extends('layouts.pegawai')

@section('title', 'Dashboard Pegawai')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card welcome-card">
            <div class="card-body text-center">
                <h2 class="mb-3">
                    <i class="fas fa-sun me-2"></i>Selamat Datang Kembali!
                </h2>
                <h4 class="mb-2">{{ $user->name }}</h4>
                <p class="mb-0">{{ $user->position }} | NIP: {{ $user->nip }}</p>
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
                <a href="{{ route('pegawai.beban-kerja') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recentEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                        <p class="text-muted">Mulai dengan menambahkan entri beban kerja pertama Anda.</p>
                        <a href="{{ route('pegawai.beban-kerja') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Entri Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
