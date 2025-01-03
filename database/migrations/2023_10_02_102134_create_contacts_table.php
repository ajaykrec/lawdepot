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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->string('name',150)->nullable();
            $table->string('email',150)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('subject',150)->nullable();      
            $table->text('message')->nullable();
            $table->integer('status')->default(0);                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
