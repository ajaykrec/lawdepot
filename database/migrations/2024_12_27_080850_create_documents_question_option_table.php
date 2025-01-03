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
        Schema::create('documents_question_option', function (Blueprint $table) {
            $table->id('option_id');
            $table->integer('document_id');      
            $table->integer('question_id');  
            $table->string('image',150)->nullable();   
            $table->string('placeholder',150)->nullable();   
            $table->string('title',200)->nullable();   
            $table->string('value',200)->nullable();   
            $table->tinyInteger('is_table_value')->comment('0:No, 1:Yes');  
            $table->tinyInteger('is_sub_question')->comment('0:No, 1:Yes');                      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_question_option');
    }
};
