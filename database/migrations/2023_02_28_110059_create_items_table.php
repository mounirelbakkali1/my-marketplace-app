<?php

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->integer('views')->default(0);
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('primary_image')->nullable();
            $table->enum(ItemStatus::class, ItemStatus::getValues())->default(ItemStatus::AVAILABLE);
            $table->timestamps();


            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
