<?php

/**
 * Migration to make edit_logs.reason column not nullable
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Update existing records with null reason to have a default value
        DB::table('edit_logs')
            ->whereNull('reason')
            ->update(['reason' => 'Tidak ada alasan yang diberikan']);

        // Make the reason column not nullable
        Schema::table('edit_logs', function (Blueprint $table) {
            $table->text('reason')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('edit_logs', function (Blueprint $table) {
            $table->text('reason')->nullable()->change();
        });
    }
};
