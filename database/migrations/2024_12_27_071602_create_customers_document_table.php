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
        Schema::create('customers_document', function (Blueprint $table) {
            $table->id('cus_document_id');   
            $table->integer('customer_id');         
            $table->integer('document_id');         
            $table->string('file_name',150)->nullable();
            $table->text('session_fields')->nullable(); 
            $table->text('filter_values')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_document');
    }
};
