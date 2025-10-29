<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdatePasswordsToPlainText extends Seeder
{
    /**
     * Update all encrypted passwords to plain text.
     */
    public function run(): void
    {
        $this->command->info('==============================================');
        $this->command->info('UPDATE PASSWORD KE PLAIN TEXT');
        $this->command->info('==============================================');
        $this->command->info('');

        // Default passwords untuk setiap role
        $defaultPasswords = [
            'admin' => 'admin123',
            'employee' => 'pegawai123',
        ];

        $users = User::all();
        $updated = 0;

        foreach ($users as $user) {
            // Cek apakah password sudah dalam format hash (biasanya dimulai dengan $2y$ dan panjang > 50)
            if (strlen($user->password) > 50 && strpos($user->password, '$2y$') === 0) {
                // Password masih dalam format hash, update ke plain text
                $newPassword = $defaultPasswords[$user->role] ?? 'password123';
                
                // Update langsung ke database tanpa trigger model events
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => $newPassword]);
                
                $this->command->info("[✓] Updated: {$user->name} ({$user->role}) - Password: {$newPassword}");
                $updated++;
            } else {
                // Password sudah plain text
                $this->command->info("[~] Skipped: {$user->name} ({$user->role}) - Already plain text");
            }
        }

        $this->command->info('');
        $this->command->info('==============================================');
        $this->command->info('SELESAI!');
        $this->command->info('==============================================');
        $this->command->info("Total users diperbarui: {$updated}");
        $this->command->info("Total users dilewati: " . ($users->count() - $updated));
        $this->command->info('');

        if ($updated > 0) {
            $this->command->info('Password default yang digunakan:');
            $this->command->info('- Admin: admin123');
            $this->command->info('- Pegawai: pegawai123');
            $this->command->info('');
        }

        $this->command->info('CATATAN: Silakan login dengan password baru.');
        $this->command->info('Admin dapat melihat dan mengubah password di menu Detail/Edit Akun.');
    }
}

