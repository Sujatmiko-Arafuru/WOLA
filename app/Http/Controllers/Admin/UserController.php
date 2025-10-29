<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna dengan fitur pencarian
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::where('role', 'employee')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->with('workloadEntries.task')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);
        
        return view('admin.kelola-akun', compact('users', 'search'));
    }

    /**
     * Tampilkan form tambah pengguna
     */
    public function create()
    {
        return view('admin.tambah-akun');
    }

    /**
     * Simpan pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip|max:20',
            'email' => 'required|email|unique:users,email|max:255',
            'position' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'position.required' => 'Jabatan wajib diisi',
            'unit.required' => 'Unit wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'position' => $request->position,
            'unit' => $request->unit,
            'role' => 'employee',
            'password' => $request->password, // Simpan tanpa enkripsi
        ]);

        return redirect()->route('admin.kelola-akun')->with('success', 'Akun pegawai berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit pengguna
     */
    public function edit(User $user)
    {
        return view('admin.edit-akun', compact('user'));
    }

    /**
     * Update pengguna
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'position' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'position.required' => 'Jabatan wajib diisi',
            'unit.required' => 'Unit wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $updateData = [
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'position' => $request->position,
            'unit' => $request->unit,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = $request->password; // Simpan tanpa enkripsi
        }

        $user->update($updateData);

        return redirect()->route('admin.kelola-akun')->with('success', 'Akun pegawai berhasil diperbarui!');
    }

    /**
     * Hapus pengguna
     */
    public function destroy(User $user)
    {
        // Cek apakah pengguna memiliki entri beban kerja
        if ($user->workloadEntries()->count() > 0) {
            return redirect()->back()->with('error', 'Akun tidak dapat dihapus karena memiliki entri beban kerja.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun pegawai berhasil dihapus!');
    }

    /**
     * Tampilkan detail pengguna
     */
    public function show(User $user)
    {
        $workloadEntries = $user->workloadEntries()
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.detail-akun', compact('user', 'workloadEntries'));
    }

    /**
     * Ambil password pengguna (untuk admin)
     */
    public function getPassword($userId)
    {
        // Ambil password langsung dari database (tanpa enkripsi untuk demo)
        // Dalam production, sebaiknya tidak menyimpan password dalam bentuk plain text
        $plainPassword = DB::table('users')->where('id', $userId)->value('password');
        
        return response()->json([
            'password' => $plainPassword
        ]);
    }
}