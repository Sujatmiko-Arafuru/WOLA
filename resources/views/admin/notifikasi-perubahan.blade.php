@extends('layouts.admin')

@section('title', 'Notifikasi Perubahan')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-bell me-2"></i>Notifikasi Perubahan
                        </h5>
                        <p class="text-muted mb-0">Pantau perubahan yang dilakukan pegawai pada entri beban kerja</p>
                    </div>
                    @if($editLogs->count() > 0)
                        <form method="POST" action="{{ route('admin.mark-all-notifications-read') }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-double me-2"></i>Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($editLogs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pegawai</th>
                                    <th>Tugas</th>
                                    <th>Alasan Pengeditan</th>
                                    <th>Perubahan</th>
                                    <th>Edit Ke-</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($editLogs as $index => $log)
                                    @if($log->user && $log->workloadEntry && $log->workloadEntry->task)
                                    <tr class="{{ !$log->admin_notified ? 'table-warning' : '' }}">
                                        <td>{{ $editLogs->firstItem() + $index }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>{{ $log->workloadEntry->task->task_description }}</td>
                                        <td>
                                            <div class="alert alert-primary mb-0 p-2" style="font-size: 0.9em;">
                                                <i class="fas fa-comment me-1"></i>
                                                <strong>{{ $log->reason ?: 'Tidak ada alasan yang diberikan' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <strong>Sebelum:</strong> {{ $log->old_quantity }} 
                                                @switch($log->old_time_unit)
                                                    @case('daily') Harian @break
                                                    @case('weekly') Mingguan @break
                                                    @case('monthly') Bulanan @break
                                                    @case('yearly') Tahunan @break
                                                @endswitch<br>
                                                <strong>Sesudah:</strong> {{ $log->new_quantity }} 
                                                @switch($log->new_time_unit)
                                                    @case('daily') Harian @break
                                                    @case('weekly') Mingguan @break
                                                    @case('monthly') Bulanan @break
                                                    @case('yearly') Tahunan @break
                                                @endswitch<br>
                                                <strong>Total Menit:</strong> {{ number_format($log->old_total_minutes) }} → {{ number_format($log->new_total_minutes) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">Edit ke-{{ $log->edit_number }}</span>
                                        </td>
                                        <td>
                                            @if($log->admin_notified)
                                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Sudah Dibaca</span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">Belum Dibaca</span>
                                            @endif
                                        </td>
                                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.detail-perubahan', $log) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$log->admin_notified)
                                                    <form method="POST" 
                                                          action="{{ route('admin.mark-notification-read', $log) }}" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" 
                                                      action="{{ route('admin.notifikasi-perubahan', $log) }}" 
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
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $editLogs->firstItem() ?? 0 }} - {{ $editLogs->lastItem() ?? 0 }} dari {{ $editLogs->total() }} notifikasi
                        </div>
                        <div>
                            {{ $editLogs->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada notifikasi</h5>
                        <p class="text-muted">Tidak ada perubahan yang perlu diperhatikan saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
