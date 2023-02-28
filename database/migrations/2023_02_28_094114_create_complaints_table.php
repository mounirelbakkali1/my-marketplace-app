<?php

use App\Enums\ComplaintStatus;
use App\Enums\ComplaintType;
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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('complaint');
            $table->enum(ComplaintStatus::class, ComplaintStatus::getValues());
            $table->enum(ComplaintType::class, ComplaintType::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
