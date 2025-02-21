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
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id('orderitem_id');
            $table->integer('order_id')->nullable(); 
            $table->integer('customer_id')->nullable(); 
            $table->integer('item_id')->nullable();       
            $table->string('item_name',150)->nullable();       
            $table->string('item_description',255)->nullable();       
            $table->integer('item_type')->nullable()->comment('0:membership, 1:product'); 
            $table->string('image',150)->nullable();       
            $table->text('options')->nullable();            
            $table->decimal('price');
            $table->integer('quantity');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_items');
    }
};
