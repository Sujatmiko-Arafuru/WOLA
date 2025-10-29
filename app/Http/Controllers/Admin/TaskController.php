<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Tampilkan daftar tugas
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.kelola-tugas', compact('tasks'));
    }

    /**
     * Tampilkan form tambah tugas
     */
    public function create()
    {
        return view('admin.tambah-tugas');
    }

    /**
     * Simpan tugas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_description' => 'required|string|max:255',
            'time_per_unit' => 'required|integer|min:1',
        ], [
            'task_description.required' => 'Uraian tugas wajib diisi',
            'task_description.max' => 'Uraian tugas maksimal 255 karakter',
            'time_per_unit.required' => 'Waktu per unit wajib diisi',
            'time_per_unit.integer' => 'Waktu per unit harus berupa angka',
            'time_per_unit.min' => 'Waktu per unit minimal 1 menit',
        ]);

        Task::create([
            'task_description' => $request->task_description,
            'time_per_unit' => $request->time_per_unit,
            'is_active' => true,
        ]);

        return redirect()->route('admin.kelola-tugas')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit tugas
     */
    public function edit(Task $task)
    {
        return view('admin.edit-tugas', compact('task'));
    }

    /**
     * Update tugas
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_description' => 'required|string|max:255',
            'time_per_unit' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ], [
            'task_description.required' => 'Uraian tugas wajib diisi',
            'task_description.max' => 'Uraian tugas maksimal 255 karakter',
            'time_per_unit.required' => 'Waktu per unit wajib diisi',
            'time_per_unit.integer' => 'Waktu per unit harus berupa angka',
            'time_per_unit.min' => 'Waktu per unit minimal 1 menit',
        ]);

        $task->update([
            'task_description' => $request->task_description,
            'time_per_unit' => $request->time_per_unit,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.kelola-tugas')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Hapus tugas
     */
    public function destroy(Task $task)
    {
        // Cek apakah tugas sudah digunakan
        if ($task->workloadEntries()->count() > 0) {
            return redirect()->back()->with('error', 'Tugas tidak dapat dihapus karena sudah digunakan dalam entri beban kerja.');
        }

        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Toggle status aktif tugas
     */
    public function toggleStatus(Task $task)
    {
        $task->update(['is_active' => !$task->is_active]);
        
        $status = $task->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()->with('success', "Tugas berhasil {$status}!");
    }
}