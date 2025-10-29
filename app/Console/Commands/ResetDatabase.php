<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset-data {--create-admin : Buat akun admin jika tidak ada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset semua data aplikasi KECUALI admin (hapus pegawai, tasks, workload, logs) untuk deployment baru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('RESET DATABASE - SISTEM ANALISIS BEBAN KERJA PEGAWAI');
        $this->warn('⚠️  PERHATIAN: Perintah ini akan menghapus data dari database!');
        $this->line('');
        
        $this->info('Data yang akan dihapus:');
        $this->line('  • Semua akun PEGAWAI (admin TIDAK dihapus)');
        $this->line('  • Semua tugas/tasks');
        $this->line('  • Semua entri beban kerja');
        $this->line('  • Semua log edit');
        $this->line('  • Semua notifikasi');
        $this->line('  • Semua sessions & cache');
        $this->line('');
        
        $this->warn('✓ Akun ADMIN akan DIPERTAHANKAN');
        $this->line('');

        if (!$this->confirm('Apakah Anda yakin ingin melanjutkan?', false)) {
            $this->error('❌ Reset dibatalkan.');
            return 1;
        }

        $this->line('');
        $this->info('🚀 Memulai proses reset...');
        $this->line('');

        // Jalankan reset database seeder
        try {
            Artisan::call('db:seed', [
                '--class' => 'ResetDatabaseSeeder',
                '--force' => true
            ]);

            $this->newLine();
            
            // Output dari seeder sudah menampilkan info admin
            // Tidak perlu create admin lagi karena sudah dipertahankan
            
            // Jika option create-admin dipakai dan tidak ada admin, buat admin baru
            if ($this->option('create-admin')) {
                $adminCount = \DB::table('users')->where('role', 'admin')->count();
                
                if ($adminCount === 0) {
                    $this->line('');
                    $this->warn('⚠️  Tidak ada admin! Membuat admin baru...');
                    
                    Artisan::call('db:seed', [
                        '--class' => 'AdminOnlySeeder',
                        '--force' => true
                    ]);
                    
                    $this->line('');
                    $this->info('✅ Akun admin baru berhasil dibuat!');
                    $this->line('');
                    $this->warn('Kredensial Admin:');
                    $this->table(
                        ['Field', 'Value'],
                        [
                            ['Email', 'admin@poltekkes-denpasar.ac.id'],
                            ['Password', 'admin123'],
                            ['NIP', 'ADMIN001'],
                            ['Role', 'Admin']
                        ]
                    );
                }
            }

            $this->line('');
            $this->info('🎉 Sistem siap digunakan untuk deployment!');
            $this->info('📝 Gunakan kredensial admin yang sama untuk login.');
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }
    }
}
