<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabaseSeeder extends Seeder
{
    /**
     * Reset database dengan menghapus semua data KECUALI akun admin
     * Seeder ini akan menghapus semua data dari tabel-tabel aplikasi
     * agar sistem siap digunakan dari awal (clean state)
     * ADMIN TETAP DIPERTAHANKAN untuk kemudahan akses
     */
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        $this->command->info('🔄 Memulai reset database...');

        // 1. Hapus data edit logs (harus pertama karena ada foreign key)
        $this->command->info('🗑️  Menghapus edit logs...');
        DB::table('edit_logs')->truncate();

        // 2. Hapus data workload entries
        $this->command->info('🗑️  Menghapus workload entries...');
        DB::table('workload_entries')->truncate();

        // 3. Hapus data tasks
        $this->command->info('🗑️  Menghapus tasks...');
        DB::table('tasks')->truncate();

        // 4. Hapus hanya data pegawai (PERTAHANKAN ADMIN)
        $this->command->info('🗑️  Menghapus data pegawai (admin dipertahankan)...');
        $deletedEmployees = DB::table('users')->where('role', 'employee')->delete();
        $this->command->info("    ✓ {$deletedEmployees} pegawai dihapus");
        
        // Hitung admin yang tersisa
        $adminCount = DB::table('users')->where('role', 'admin')->count();
        $this->command->warn("    ℹ {$adminCount} akun admin dipertahankan");

        // 5. Hapus data sessions
        $this->command->info('🗑️  Menghapus sessions...');
        DB::table('sessions')->truncate();

        // 6. Hapus password reset tokens
        $this->command->info('🗑️  Menghapus password reset tokens...');
        DB::table('password_reset_tokens')->truncate();

        // 7. Hapus cache (jika ada)
        if (Schema::hasTable('cache')) {
            $this->command->info('🗑️  Menghapus cache...');
            DB::table('cache')->truncate();
        }

        if (Schema::hasTable('cache_locks')) {
            DB::table('cache_locks')->truncate();
        }

        // 8. Hapus jobs (jika ada)
        if (Schema::hasTable('jobs')) {
            $this->command->info('🗑️  Menghapus jobs...');
            DB::table('jobs')->truncate();
        }

        if (Schema::hasTable('job_batches')) {
            DB::table('job_batches')->truncate();
        }

        if (Schema::hasTable('failed_jobs')) {
            DB::table('failed_jobs')->truncate();
        }

        // 9. Hapus notifications (jika ada)
        if (Schema::hasTable('notifications')) {
            $this->command->info('🗑️  Menghapus notifications...');
            DB::table('notifications')->truncate();
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->command->info('✅ Database berhasil direset!');
        $this->command->line('');
        
        // Tampilkan ringkasan admin yang ada
        $admins = DB::table('users')->where('role', 'admin')->get(['name', 'email', 'nip']);
        
        if ($admins->count() > 0) {
            $this->command->warn('👤 Admin yang tersisa:');
            foreach ($admins as $admin) {
                $this->command->line("   • {$admin->name} ({$admin->email}) - NIP: {$admin->nip}");
            }
            $this->command->line('');
            $this->command->info('📝 Gunakan kredensial admin yang ada untuk login.');
        } else {
            $this->command->warn('⚠️  Tidak ada admin! Buat admin dengan: php artisan db:seed --class=AdminOnlySeeder');
        }
        
        $this->command->line('');
        $this->command->info('🎉 Sistem siap digunakan dari awal dengan admin yang sama!');
    }
}

