<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\WorkloadEntry;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WorkloadEntry::truncate();
        Task::truncate();
        User::where('role', 'employee')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating dummy data...');

        // Array of units
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

        // Create Tasks
        $tasks = [
            // Tugas Administratif
            ['task_description' => 'Membuat laporan bulanan', 'time_per_unit' => 120, 'is_active' => true],
            ['task_description' => 'Mengarsipkan dokumen', 'time_per_unit' => 30, 'is_active' => true],
            ['task_description' => 'Meeting koordinasi', 'time_per_unit' => 90, 'is_active' => true],
            ['task_description' => 'Menyusun surat keputusan', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Verifikasi data', 'time_per_unit' => 45, 'is_active' => true],
            
            // Tugas Akademik
            ['task_description' => 'Mengajar kelas teori', 'time_per_unit' => 150, 'is_active' => true],
            ['task_description' => 'Mengajar kelas praktik', 'time_per_unit' => 180, 'is_active' => true],
            ['task_description' => 'Membimbing mahasiswa', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Mengoreksi ujian', 'time_per_unit' => 90, 'is_active' => true],
            ['task_description' => 'Menyusun materi perkuliahan', 'time_per_unit' => 120, 'is_active' => true],
            ['task_description' => 'Penelitian dan pengembangan', 'time_per_unit' => 180, 'is_active' => true],
            
            // Tugas IT
            ['task_description' => 'Maintenance sistem', 'time_per_unit' => 120, 'is_active' => true],
            ['task_description' => 'Troubleshooting hardware', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Update database', 'time_per_unit' => 90, 'is_active' => true],
            ['task_description' => 'Backup data', 'time_per_unit' => 45, 'is_active' => true],
            
            // Tugas Perpustakaan
            ['task_description' => 'Katalogisasi buku', 'time_per_unit' => 30, 'is_active' => true],
            ['task_description' => 'Pelayanan peminjaman', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Inventarisasi koleksi', 'time_per_unit' => 90, 'is_active' => true],
            
            // Tugas Laboratorium
            ['task_description' => 'Persiapan alat praktikum', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Kalibrasi alat laboratorium', 'time_per_unit' => 90, 'is_active' => true],
            ['task_description' => 'Maintenance laboratorium', 'time_per_unit' => 120, 'is_active' => true],
            
            // Tugas Keuangan
            ['task_description' => 'Verifikasi kuitansi', 'time_per_unit' => 45, 'is_active' => true],
            ['task_description' => 'Rekonsiliasi bank', 'time_per_unit' => 120, 'is_active' => true],
            ['task_description' => 'Membuat laporan keuangan', 'time_per_unit' => 180, 'is_active' => true],
            ['task_description' => 'Entry data transaksi', 'time_per_unit' => 30, 'is_active' => true],
            
            // Tugas Kemahasiswaan
            ['task_description' => 'Koordinasi kegiatan mahasiswa', 'time_per_unit' => 90, 'is_active' => true],
            ['task_description' => 'Bimbingan organisasi', 'time_per_unit' => 60, 'is_active' => true],
            ['task_description' => 'Administrasi beasiswa', 'time_per_unit' => 75, 'is_active' => true],
            
            // Tugas Kepegawaian
            ['task_description' => 'Input data kepegawaian', 'time_per_unit' => 45, 'is_active' => true],
            ['task_description' => 'Proses absensi', 'time_per_unit' => 30, 'is_active' => true],
            ['task_description' => 'Membuat SK kepegawaian', 'time_per_unit' => 90, 'is_active' => true],
        ];

        $createdTasks = [];
        foreach ($tasks as $task) {
            $createdTasks[] = Task::create($task);
        }
        $this->command->info('Created ' . count($createdTasks) . ' tasks');

        // Create Employees
        $employees = [
            // Unit IT
            ['name' => 'Ahmad Fauzi', 'nip' => '198501012010011001', 'email' => 'ahmad.fauzi@poltekkes.ac.id', 'position' => 'Kepala Unit IT', 'unit' => 'Unit IT'],
            ['name' => 'Siti Rahma', 'nip' => '199002152015022001', 'email' => 'siti.rahma@poltekkes.ac.id', 'position' => 'System Administrator', 'unit' => 'Unit IT'],
            ['name' => 'Budi Santoso', 'nip' => '198803202012011002', 'email' => 'budi.santoso@poltekkes.ac.id', 'position' => 'Network Engineer', 'unit' => 'Unit IT'],
            
            // Unit Pengelola Usaha
            ['name' => 'Dewi Lestari', 'nip' => '198707102014022001', 'email' => 'dewi.lestari@poltekkes.ac.id', 'position' => 'Kepala Unit Usaha', 'unit' => 'Unit Pengelola Usaha'],
            ['name' => 'Rizki Pratama', 'nip' => '199105252016011001', 'email' => 'rizki.pratama@poltekkes.ac.id', 'position' => 'Staff Usaha', 'unit' => 'Unit Pengelola Usaha'],
            
            // Unit Pengembangan Bahasa
            ['name' => 'Linda Wahyuni', 'nip' => '198509182013022001', 'email' => 'linda.wahyuni@poltekkes.ac.id', 'position' => 'Dosen Bahasa Inggris', 'unit' => 'Unit Pengembangan Bahasa'],
            ['name' => 'Hendra Wijaya', 'nip' => '199001122015011001', 'email' => 'hendra.wijaya@poltekkes.ac.id', 'position' => 'Instruktur Bahasa', 'unit' => 'Unit Pengembangan Bahasa'],
            
            // Unit Laboratorium Terpadu
            ['name' => 'Eka Purwanti', 'nip' => '198612012014022002', 'email' => 'eka.purwanti@poltekkes.ac.id', 'position' => 'Kepala Laboratorium', 'unit' => 'Unit Laboratorium Terpadu'],
            ['name' => 'Agus Setiawan', 'nip' => '199203102017011001', 'email' => 'agus.setiawan@poltekkes.ac.id', 'position' => 'Laboran', 'unit' => 'Unit Laboratorium Terpadu'],
            ['name' => 'Maya Sari', 'nip' => '199408222018022001', 'email' => 'maya.sari@poltekkes.ac.id', 'position' => 'Asisten Laboran', 'unit' => 'Unit Laboratorium Terpadu'],
            
            // Unit Perpustakaan Terpadu
            ['name' => 'Dian Puspita', 'nip' => '198804152013022001', 'email' => 'dian.puspita@poltekkes.ac.id', 'position' => 'Kepala Perpustakaan', 'unit' => 'Unit Perpustakaan Terpadu'],
            ['name' => 'Rian Kurniawan', 'nip' => '199106302016011002', 'email' => 'rian.kurniawan@poltekkes.ac.id', 'position' => 'Pustakawan', 'unit' => 'Unit Perpustakaan Terpadu'],
            
            // Akademik
            ['name' => 'Dr. Suryani', 'nip' => '197805102005022001', 'email' => 'suryani@poltekkes.ac.id', 'position' => 'Wakil Direktur Akademik', 'unit' => 'Akademik'],
            ['name' => 'Fitri Handayani', 'nip' => '198906152014022001', 'email' => 'fitri.handayani@poltekkes.ac.id', 'position' => 'Kasubag Akademik', 'unit' => 'Akademik'],
            ['name' => 'Yoga Prasetyo', 'nip' => '199209202017011001', 'email' => 'yoga.prasetyo@poltekkes.ac.id', 'position' => 'Staff Akademik', 'unit' => 'Akademik'],
            
            // Kemahasiswaan
            ['name' => 'Rini Astuti', 'nip' => '198708252013022002', 'email' => 'rini.astuti@poltekkes.ac.id', 'position' => 'Kepala Kemahasiswaan', 'unit' => 'Kemahasiswaan'],
            ['name' => 'Andi Wijaya', 'nip' => '199104122016011001', 'email' => 'andi.wijaya@poltekkes.ac.id', 'position' => 'Staff Kemahasiswaan', 'unit' => 'Kemahasiswaan'],
            
            // Umum
            ['name' => 'Bambang Susilo', 'nip' => '198305152010011001', 'email' => 'bambang.susilo@poltekkes.ac.id', 'position' => 'Kepala Bagian Umum', 'unit' => 'Umum'],
            ['name' => 'Yuni Safitri', 'nip' => '199007182015022001', 'email' => 'yuni.safitri@poltekkes.ac.id', 'position' => 'Staff Umum', 'unit' => 'Umum'],
            
            // Keuangan dan BMN
            ['name' => 'Irfan Hakim', 'nip' => '198502282011011001', 'email' => 'irfan.hakim@poltekkes.ac.id', 'position' => 'Kepala Keuangan', 'unit' => 'Keuangan dan BMN'],
            ['name' => 'Sri Wahyuni', 'nip' => '198909122014022002', 'email' => 'sri.wahyuni@poltekkes.ac.id', 'position' => 'Bendahara', 'unit' => 'Keuangan dan BMN'],
            ['name' => 'Fajar Nugroho', 'nip' => '199201252017011001', 'email' => 'fajar.nugroho@poltekkes.ac.id', 'position' => 'Staff Keuangan', 'unit' => 'Keuangan dan BMN'],
            
            // Kepegawaian
            ['name' => 'Wulan Dari', 'nip' => '198610152013022001', 'email' => 'wulan.dari@poltekkes.ac.id', 'position' => 'Kepala Kepegawaian', 'unit' => 'Kepegawaian'],
            ['name' => 'Dedi Irawan', 'nip' => '199105102016011001', 'email' => 'dedi.irawan@poltekkes.ac.id', 'position' => 'Staff Kepegawaian', 'unit' => 'Kepegawaian'],
            
            // Jurusan Keperawatan
            ['name' => 'Dr. Ani Suryani', 'nip' => '197603122003022001', 'email' => 'ani.suryani@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Keperawatan'],
            ['name' => 'Ns. Rani Permata', 'nip' => '198804202014022001', 'email' => 'rani.permata@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Keperawatan'],
            ['name' => 'Ns. Hadi Santoso', 'nip' => '199001152016011001', 'email' => 'hadi.santoso@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Keperawatan'],
            
            // Jurusan Kebidanan
            ['name' => 'Dr. Sari Rahayu', 'nip' => '197705182004022001', 'email' => 'sari.rahayu@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Kebidanan'],
            ['name' => 'Bd. Lina Marlina', 'nip' => '198907252015022001', 'email' => 'lina.marlina@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Kebidanan'],
            ['name' => 'Bd. Novi Anggraini', 'nip' => '199102102017022001', 'email' => 'novi.anggraini@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Kebidanan'],
            
            // Jurusan Kesehatan Gigi
            ['name' => 'drg. Rudi Hermawan', 'nip' => '197808252005011001', 'email' => 'rudi.hermawan@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Kesehatan Gigi'],
            ['name' => 'drg. Putri Ayu', 'nip' => '199003182016022001', 'email' => 'putri.ayu@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Kesehatan Gigi'],
            
            // Jurusan Gizi
            ['name' => 'Dr. Indah Kusuma', 'nip' => '197906122006022001', 'email' => 'indah.kusuma@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Gizi'],
            ['name' => 'Lilis Suryani', 'nip' => '199005252016022001', 'email' => 'lilis.suryani@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Gizi'],
            
            // Jurusan Kesehatan Lingkungan
            ['name' => 'Ir. Budi Hartono', 'nip' => '197712282007011001', 'email' => 'budi.hartono@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Kesehatan Lingkungan'],
            ['name' => 'Rina Wati', 'nip' => '198908152015022001', 'email' => 'rina.wati@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Kesehatan Lingkungan'],
            
            // Jurusan Teknologi Laboratorium Medis
            ['name' => 'Dr. Andi Pratama', 'nip' => '197804152005011001', 'email' => 'andi.pratama@poltekkes.ac.id', 'position' => 'Ketua Jurusan', 'unit' => 'Jurusan Teknologi Laboratorium Medis'],
            ['name' => 'Yuli Andriani', 'nip' => '199004202017022001', 'email' => 'yuli.andriani@poltekkes.ac.id', 'position' => 'Dosen', 'unit' => 'Jurusan Teknologi Laboratorium Medis'],
            
            // Satuan Pengawas Internal
            ['name' => 'Drs. Agung Nugroho', 'nip' => '197509102008011001', 'email' => 'agung.nugroho@poltekkes.ac.id', 'position' => 'Kepala SPI', 'unit' => 'Satuan Pengawas Internal'],
            ['name' => 'Rina Kusuma', 'nip' => '198806252015022001', 'email' => 'rina.kusuma@poltekkes.ac.id', 'position' => 'Auditor', 'unit' => 'Satuan Pengawas Internal'],
        ];

        $createdEmployees = [];
        foreach ($employees as $employee) {
            $createdEmployees[] = User::create([
                'name' => $employee['name'],
                'nip' => $employee['nip'],
                'email' => $employee['email'],
                'position' => $employee['position'],
                'unit' => $employee['unit'],
                'role' => 'employee',
                'password' => '123456789', // Password tanpa enkripsi untuk semua
            ]);
        }
        $this->command->info('Created ' . count($createdEmployees) . ' employees');

        // Create Workload Entries for each employee
        $timeUnits = ['daily', 'weekly', 'monthly', 'yearly'];
        $workloadCount = 0;

        foreach ($createdEmployees as $employee) {
            // Setiap pegawai akan punya 3-6 tugas dengan distribusi yang bervariasi
            $numTasks = rand(3, 6);
            $usedTaskIds = [];
            
            for ($i = 0; $i < $numTasks; $i++) {
                // Pilih task random yang belum digunakan
                do {
                    $task = $createdTasks[array_rand($createdTasks)];
                } while (in_array($task->id, $usedTaskIds));
                
                $usedTaskIds[] = $task->id;
                
                // Random time unit dan quantity
                $timeUnit = $timeUnits[array_rand($timeUnits)];
                
                // Quantity berbeda berdasarkan time unit
                switch ($timeUnit) {
                    case 'daily':
                        $quantity = rand(1, 3);
                        break;
                    case 'weekly':
                        $quantity = rand(1, 5);
                        break;
                    case 'monthly':
                        $quantity = rand(1, 4);
                        break;
                    case 'yearly':
                        $quantity = rand(1, 3);
                        break;
                }
                
                WorkloadEntry::create([
                    'user_id' => $employee->id,
                    'task_id' => $task->id,
                    'quantity' => $quantity,
                    'time_unit' => $timeUnit,
                    'total_minutes' => $quantity * $task->time_per_unit,
                    'edit_count' => 0,
                ]);
                
                $workloadCount++;
            }
        }

        $this->command->info('Created ' . $workloadCount . ' workload entries');
        $this->command->info('');
        $this->command->info('=================================');
        $this->command->info('Dummy data created successfully!');
        $this->command->info('=================================');
        $this->command->info('Total Employees: ' . count($createdEmployees));
        $this->command->info('Total Tasks: ' . count($createdTasks));
        $this->command->info('Total Workload Entries: ' . $workloadCount);
        $this->command->info('Password for all employees: 123456789');
    }
}
