<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminOnlySeeder extends Seeder
{
    /**
     * Seed hanya akun admin untuk deployment baru
     * Tanpa sample employee
     */
    public function run(): void
    {
        // Create admin user - Password tanpa enkripsi
        User::create([
            'name' => 'Administrator',
            'nip' => 'ADMIN001',
            'email' => 'admin@poltekkes-denpasar.ac.id',
            'position' => 'Administrator Sistem',
            'role' => 'admin',
            'password' => 'admin123',
        ]);

        echo "✅ Akun admin berhasil dibuat!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 Email    : admin@poltekkes-denpasar.ac.id\n";
        echo "🔑 Password : admin123\n";
        echo "👤 Role     : Admin\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "⚠️  Jangan lupa ubah password setelah login!\n";
    }
}

