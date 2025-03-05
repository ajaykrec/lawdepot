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
        Schema::create('country', function (Blueprint $table) {
            $table->id('country_id');   
            $table->integer('language_id');         
            $table->string('name',200)->nullable();
            $table->string('code',200)->unique();
            $table->string('currency_code',10)->unique();    
            $table->string('image',200)->nullable();  
            $table->integer('default');            
            $table->integer('sort_order');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country');
    }
};
