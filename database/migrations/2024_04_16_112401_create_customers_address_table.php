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
        Schema::create('customers_address', function (Blueprint $table) {
            $table->id('address_id'); 
            $table->integer('customer_id');            
            $table->string('title',150)->nullable();
            $table->string('company',150)->nullable();
            $table->string('address',150)->nullable();           
            $table->string('postcode',15)->nullable();
            $table->integer('country_id');
            $table->integer('zone_id');
            $table->string('city',150)->nullable();
            $table->integer('default'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_address');
    }
};
