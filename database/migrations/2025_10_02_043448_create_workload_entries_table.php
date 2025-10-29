<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workload_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Jumlah qty yang dikerjakan
            $table->enum('time_unit', ['daily', 'weekly', 'monthly', 'yearly']); // Harian, Mingguan, Bulanan, Tahunan
            $table->integer('total_minutes'); // Total menit yang dihitung sistem
            $table->integer('edit_count')->default(0); // Counter untuk edit ke-x
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workload_entries');
    }
};
