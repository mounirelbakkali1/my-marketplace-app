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
        Schema::create('complaints_resolved', function (Blueprint $table) {
            $table->id();
            $table->integer('complaint_id');
            $table->integer('employee_id')->comment('employee who resolved the complaint');
            $table->timestamps();
            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints_resolved');
    }
};
