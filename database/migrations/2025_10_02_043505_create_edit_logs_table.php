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
        Schema::create('edit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workload_entry_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('old_quantity');
            $table->integer('new_quantity');
            $table->enum('old_time_unit', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->enum('new_time_unit', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->integer('old_total_minutes');
            $table->integer('new_total_minutes');
            $table->text('reason')->nullable(); // Alasan pengeditan
            $table->integer('edit_number'); // Edit ke-x
            $table->boolean('admin_notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_logs');
    }
};
