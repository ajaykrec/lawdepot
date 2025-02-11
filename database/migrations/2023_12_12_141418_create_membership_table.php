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
        Schema::create('membership', function (Blueprint $table) {
            $table->id('membership_id');  
            $table->integer('country_id');       
            $table->string('name',150)->nullable();   
            $table->text('description')->nullable();  
            $table->text('specification')->nullable();  
            $table->decimal('price'); 
            $table->integer('time_period');    
            $table->enum('time_period_sufix',['week','month','year']); 
            $table->string('button_color',50)->nullable();  
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
        Schema::dropIfExists('membership');
    }
};
