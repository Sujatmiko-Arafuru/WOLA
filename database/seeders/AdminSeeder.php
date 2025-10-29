<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        // Create sample employee - Password tanpa enkripsi
        User::create([
            'name' => 'Dr. Siti Nurhaliza',
            'nip' => '196501011990032001',
            'email' => 'siti.nurhaliza@poltekkes-denpasar.ac.id',
            'position' => 'Dosen Senior',
            'role' => 'employee',
            'password' => 'pegawai123',
        ]);

        User::create([
            'name' => 'Prof. Dr. Ahmad Wijaya',
            'nip' => '196203151985031001',
            'email' => 'ahmad.wijaya@poltekkes-denpasar.ac.id',
            'position' => 'Ketua Program Studi',
            'role' => 'employee',
            'password' => 'pegawai123',
        ]);

        User::create([
            'name' => 'Dr. Maria Magdalena',
            'nip' => '197508201999032002',
            'email' => 'maria.magdalena@poltekkes-denpasar.ac.id',
            'position' => 'Dosen',
            'role' => 'employee',
            'password' => 'pegawai123',
        ]);
    }
}