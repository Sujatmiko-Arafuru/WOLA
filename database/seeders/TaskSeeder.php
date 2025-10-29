<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'task_description' => 'Membuat surat keluar',
                'time_per_unit' => 30,
            ],
            [
                'task_description' => 'Membuat laporan bulanan',
                'time_per_unit' => 120,
            ],
            [
                'task_description' => 'Melaksanakan evaluasi pembelajaran',
                'time_per_unit' => 240,
            ],
            [
                'task_description' => 'Membuat laporan tahunan',
                'time_per_unit' => 300,
            ],
            [
                'task_description' => 'Menyiapkan materi pembelajaran',
                'time_per_unit' => 90,
            ],
            [
                'task_description' => 'Melakukan penelitian',
                'time_per_unit' => 180,
            ],
            [
                'task_description' => 'Mengikuti rapat koordinasi',
                'time_per_unit' => 60,
            ],
            [
                'task_description' => 'Membuat proposal penelitian',
                'time_per_unit' => 150,
            ],
            [
                'task_description' => 'Melakukan supervisi klinik',
                'time_per_unit' => 120,
            ],
            [
                'task_description' => 'Membuat artikel jurnal',
                'time_per_unit' => 200,
            ],
            [
                'task_description' => 'Melakukan konsultasi pasien',
                'time_per_unit' => 45,
            ],
            [
                'task_description' => 'Menyusun kurikulum',
                'time_per_unit' => 180,
            ],
            [
                'task_description' => 'Melakukan pengabdian masyarakat',
                'time_per_unit' => 120,
            ],
            [
                'task_description' => 'Membuat presentasi seminar',
                'time_per_unit' => 90,
            ],
            [
                'task_description' => 'Melakukan evaluasi kinerja',
                'time_per_unit' => 60,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create([
                'task_description' => $task['task_description'],
                'time_per_unit' => $task['time_per_unit'],
                'is_active' => true,
            ]);
        }
    }
}