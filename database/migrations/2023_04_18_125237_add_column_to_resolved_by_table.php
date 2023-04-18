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
        Schema::table('complaints_resolved', function (Blueprint $table) {
            $table->renameColumn('employee_id', 'resolved_by');
            $table->text('resolved_note')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resolved_by', function (Blueprint $table) {
            //
        });
    }
};
