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
        Schema::create('documents_faq', function (Blueprint $table) {
            $table->id('dfaq_id');   
            $table->integer('step_id');           
            $table->string('question',255);
            $table->text('answer');   
            $table->integer('label_group');  
            $table->enum('status',[0,1]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_faq');
    }
};
