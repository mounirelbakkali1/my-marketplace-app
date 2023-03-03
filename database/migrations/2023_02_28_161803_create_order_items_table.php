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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->float('item_price');
            $table->integer('quantity');
            $table->integer('order_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->timestamps();


            $table->foreign('order_id')->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('item_id')->references('id')
                ->on('items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
