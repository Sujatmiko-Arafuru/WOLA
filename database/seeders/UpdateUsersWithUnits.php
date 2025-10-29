<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUsersWithUnits extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of available units
        $units = [
            'Unit IT',
            'Unit Pengelola Usaha',
            'Unit Pengembangan Bahasa',
            'Unit Laboratorium Terpadu',
            'Unit Perpustakaan Terpadu',
            'Unit Pengembangan Kompetensi',
            'Akademik',
            'Kemahasiswaan',
            'Umum',
            'Keuangan dan BMN',
            'Kepegawaian',
            'Jurusan Keperawatan',
            'Jurusan Kebidanan',
            'Jurusan Kesehatan Gigi',
            'Jurusan Gizi',
            'Jurusan Kesehatan Lingkungan',
            'Jurusan Teknologi Laboratorium Medis',
            'Satuan Pengawas Internal',
        ];

        // Get all users without a unit
        $users = User::whereNull('unit')->orWhere('unit', '')->get();

        // Update each user with a random unit
        foreach ($users as $user) {
            $randomUnit = $units[array_rand($units)];
            $user->update(['unit' => $randomUnit]);
            
            $this->command->info("Updated {$user->name} with unit: {$randomUnit}");
        }

        $this->command->info("Successfully updated {$users->count()} users with random units!");
    }
}
