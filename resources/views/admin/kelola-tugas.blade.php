@extends('layouts.admin')

@section('title', 'Kelola Tugas')

@section('content')
<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-tasks me-2"></i>Kelola Tugas
                        </h5>
                        <p class="text-muted mb-0">Kelola uraian tugas dan waktu per unit untuk sistem beban kerja</p>
                    </div>
                    <a href="{{ route('admin.tambah-tugas') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Tugas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tasks Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($tasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Uraian Tugas</th>
                                    <th>Waktu per Unit</th>
                                    <th>Status</th>
                                    <th>Total Digunakan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $index => $task)
                                    <tr>
                                        <td>{{ $tasks->firstItem() + $index }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #17a2b8, #138496);">{{ $task->time_per_unit }} menit</span>
                                        </td>
                                        <td>
                                            @if($task->is_active)
                                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Aktif</span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #6c757d, #495057);">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #1e5f5f, #2d8f8f);">{{ $task->workloadEntries->count() }} kali</span>
                                        </td>
                                        <td>{{ $task->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.edit-tugas', $task) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('admin.toggle-status-tugas', $task) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-sm {{ $task->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                            title="{{ $task->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas {{ $task->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" 
                                                      action="{{ route('admin.kelola-tugas', $task) }}" 
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
                            Menampilkan {{ $tasks->firstItem() ?? 0 }} - {{ $tasks->lastItem() ?? 0 }} dari {{ $tasks->total() }} tugas
                        </div>
                        <div>
                            {{ $tasks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tasks fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada tugas</h5>
                        <p class="text-muted">Mulai dengan menambahkan tugas pertama.</p>
                        <a href="{{ route('admin.tambah-tugas') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Tugas Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
