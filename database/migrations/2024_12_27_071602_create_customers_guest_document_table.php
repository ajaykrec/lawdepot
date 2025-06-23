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
        Schema::create('customers_guest_document', function (Blueprint $table){
            $table->id('guest_document_id');   
            $table->integer('document_id');  
            $table->string('ip_address',150)->nullable();  
            $table->text('session_fields')->nullable(); 
            $table->text('filter_values')->nullable();             
            $table->text('openai_document')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_guest_document');
    }
};
