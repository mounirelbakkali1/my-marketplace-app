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
            $table->integer('seller_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('collection_id')->unsigned();
            $table->string('primary_image')->nullable();
            $table->enum(ItemStatus::class, ItemStatus::getValues())->default(ItemStatus::AVAILABLE);
            $table->timestamps();


            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('collection_id')->references('id')->on('collections');
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
