@extends('layouts.admin')

@section('title', 'Detail Beban Kerja - ' . $user->name)

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-history me-2"></i>Riwayat Beban Kerja
                        </h5>
                        <p class="text-muted mb-0">Detail beban kerja pegawai</p>
                    </div>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <a href="{{ route('admin.laporan.pegawai.pdf', $user->nip) }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employee Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-2"><strong>Nama:</strong></p>
                        <p class="text-muted">{{ $user->name }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-2"><strong>NIP:</strong></p>
                        <p class="text-muted">{{ $user->nip }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-2"><strong>Unit:</strong></p>
                        <span class="badge bg-primary">{{ $user->unit }}</span>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-2"><strong>Jabatan:</strong></p>
                        <p class="text-muted">{{ $user->position }}</p>
                    </div>
                </div>
                <hr class="my-3">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="text-primary mb-1">{{ number_format($totalMinutesPerDay, 1) }}</h3>
                        <small class="text-muted">Total Beban (menit/hari)</small>
                    </div>
                    <div class="col-md-4">
                        @php
                            $diff = $totalMinutesPerDay - 300;
                            $diffColor = $diff > 0 ? 'danger' : ($diff < 0 ? 'warning' : 'success');
                        @endphp
                        <h3 class="text-{{ $diffColor }} mb-1">{{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}</h3>
                        <small class="text-muted">Selisih dari Target (300 menit)</small>
                    </div>
                    <div class="col-md-4">
                        @if($status === 'optimal')
                            <span class="badge bg-success fs-5 px-4 py-2">
                                <i class="fas fa-check-circle me-1"></i>Optimal
                            </span>
                        @elseif($status === 'overload')
                            <span class="badge bg-danger fs-5 px-4 py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>Berlebih
                            </span>
                        @else
                            <span class="badge bg-warning fs-5 px-4 py-2">
                                <i class="fas fa-arrow-down me-1"></i>Kurang
                            </span>
                        @endif
                        <br><small class="text-muted mt-1 d-block">Status Beban Kerja</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Workload Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($user->workloadEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: #1e5f5f; color: white;">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 35%;">Uraian Tugas</th>
                                    <th style="width: 12%;" class="text-center">Jumlah</th>
                                    <th style="width: 15%;">Satuan</th>
                                    <th style="width: 15%;" class="text-end">Total Menit</th>
                                    <th style="width: 10%;" class="text-center">Edit Ke-</th>
                                    <th style="width: 13%;">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->workloadEntries as $index => $entry)
                                    @php
                                        $timeUnitLabels = [
                                            'daily' => 'Harian',
                                            'weekly' => 'Mingguan',
                                            'monthly' => 'Bulanan',
                                            'yearly' => 'Tahunan'
                                        ];
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $entry->task->task_description }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <strong class="text-primary">{{ $entry->quantity }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #17a2b8;">
                                                {{ $timeUnitLabels[$entry->time_unit] ?? ucfirst($entry->time_unit) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($entry->total_minutes) }} menit</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">Original</span>
                                        </td>
                                        <td>
                                            <small>{{ $entry->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Summary -->
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fas fa-tasks me-2"></i>
                                <strong>Total Tugas:</strong> {{ $user->workloadEntries->count() }} tugas
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Total Beban:</strong> {{ number_format($totalMinutesPerDay, 1) }} menit/hari
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-bullseye me-2"></i>
                                <strong>Target:</strong> 300 menit/hari (5 jam efektif)
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Data Beban Kerja</h5>
                        <p class="text-muted">Pegawai ini belum memiliki tugas yang ditugaskan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Keterangan
                </h6>
                <ul class="mb-0">
                    <li><strong>Total Menit:</strong> Total waktu yang dibutuhkan untuk menyelesaikan tugas (sebelum dikonversi per hari)</li>
                    <li><strong>Satuan:</strong> Frekuensi tugas dilakukan (Harian, Mingguan, Bulanan, atau Tahunan)</li>
                    <li><strong>Edit Ke-:</strong> Menunjukkan jumlah kali data telah diubah (<span class="badge bg-success">Original</span> = belum pernah diubah)</li>
                    <li><strong>Status Beban Kerja:</strong> Ditampilkan di bagian atas berdasarkan total keseluruhan beban kerja pegawai</li>
                    <li><strong>Target Optimal:</strong> 300 menit/hari dengan toleransi ±10 menit (290-310 menit/hari)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

