<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditLog;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi perubahan
     */
    public function index()
    {
        $editLogs = EditLog::with(['user', 'workloadEntry.task'])
            ->whereHas('user') // Only get logs where user still exists
            ->whereHas('workloadEntry.task') // Only get logs where task still exists
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.notifikasi-perubahan', compact('editLogs'));
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(EditLog $editLog)
    {
        $editLog->update(['admin_notified' => true]);

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        EditLog::where('admin_notified', false)->update(['admin_notified' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Tampilkan detail perubahan
     */
    public function show(EditLog $editLog)
    {
        return view('admin.detail-perubahan', compact('editLog'));
    }

    /**
     * Hapus notifikasi
     */
    public function destroy(EditLog $editLog)
    {
        $editLog->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}