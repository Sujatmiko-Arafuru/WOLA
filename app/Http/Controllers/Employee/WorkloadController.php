<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\WorkloadEntry;
use App\Models\Task;
use App\Models\EditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkloadController extends Controller
{
    /**
     * Tampilkan halaman input beban kerja
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all active tasks (no server-side filtering needed)
        $tasks = Task::active()->orderBy('task_description', 'asc')->get();
        
        // Ambil entri beban kerja pegawai
        $workloadEntries = WorkloadEntry::where('user_id', $user->id)
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.beban-kerja', compact('tasks', 'workloadEntries'));
    }

    /**
     * Simpan entri beban kerja baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'quantity' => 'required|integer|min:1',
            'time_unit' => 'required|in:daily,weekly,monthly,yearly',
        ], [
            'task_id.required' => 'Pilih tugas terlebih dahulu',
            'task_id.exists' => 'Tugas yang dipilih tidak valid',
            'quantity.required' => 'Jumlah wajib diisi',
            'quantity.integer' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah minimal 1',
            'time_unit.required' => 'Satuan waktu wajib dipilih',
            'time_unit.in' => 'Satuan waktu tidak valid',
        ]);

        $task = Task::findOrFail($request->task_id);
        $user = Auth::user();

        // Buat entri beban kerja dengan rumus baru
        $workloadEntry = WorkloadEntry::create([
            'user_id' => $user->id,
            'task_id' => $request->task_id,
            'quantity' => $request->quantity,
            'time_unit' => $request->time_unit,
            'total_minutes' => 0, // Akan dihitung otomatis oleh model
            'edit_count' => 0,
        ]);

        // Update total_minutes menggunakan method calculateTotalMinutes dari model
        $workloadEntry->update([
            'total_minutes' => $workloadEntry->calculateTotalMinutes()
        ]);

        return redirect()->back()->with('success', 'Beban kerja berhasil disimpan!');
    }

    /**
     * Tampilkan form edit beban kerja
     */
    public function edit(WorkloadEntry $workloadEntry)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($workloadEntry->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit entri ini.');
        }

        $tasks = Task::active()->get();
        
        return view('pegawai.edit-beban-kerja', compact('workloadEntry', 'tasks'));
    }

    /**
     * Update beban kerja
     */
    public function update(Request $request, $id)
    {
        $workloadEntry = WorkloadEntry::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa edit
        if ($workloadEntry->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit entri ini.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'time_unit' => 'required|in:daily,weekly,monthly,yearly',
            'reason' => 'required|string|max:500',
        ], [
            'quantity.required' => 'Jumlah wajib diisi',
            'quantity.integer' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah minimal 1',
            'time_unit.required' => 'Satuan waktu wajib dipilih',
            'time_unit.in' => 'Satuan waktu tidak valid',
            'reason.required' => 'Alasan pengeditan wajib diisi',
            'reason.max' => 'Alasan maksimal 500 karakter',
        ]);

        DB::beginTransaction();
        
        try {
            // Simpan data lama untuk log
            $oldData = [
                'quantity' => $workloadEntry->quantity,
                'time_unit' => $workloadEntry->time_unit,
                'total_minutes' => $workloadEntry->total_minutes,
            ];

            // Update entri beban kerja
            $workloadEntry->update([
                'quantity' => $request->quantity,
                'time_unit' => $request->time_unit,
                'edit_count' => $workloadEntry->edit_count + 1,
            ]);

            // Hitung total menit baru menggunakan method dari model
            $newTotalMinutes = $workloadEntry->calculateTotalMinutes();
            $workloadEntry->update(['total_minutes' => $newTotalMinutes]);

            // Buat log pengeditan
            EditLog::create([
                'workload_entry_id' => $workloadEntry->id,
                'user_id' => Auth::id(),
                'old_quantity' => $oldData['quantity'],
                'new_quantity' => $request->quantity,
                'old_time_unit' => $oldData['time_unit'],
                'new_time_unit' => $request->time_unit,
                'old_total_minutes' => $oldData['total_minutes'],
                'new_total_minutes' => $newTotalMinutes,
                'reason' => $request->reason,
                'edit_number' => $workloadEntry->edit_count,
                'admin_notified' => false,
            ]);

            DB::commit();

            return redirect()->route('pegawai.beban-kerja')->with('success', 'Beban kerja berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Hapus entri beban kerja
     */
    public function destroy(WorkloadEntry $workloadEntry)
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($workloadEntry->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus entri ini.');
        }

        $workloadEntry->delete();

        return redirect()->back()->with('success', 'Entri beban kerja berhasil dihapus!');
    }

}