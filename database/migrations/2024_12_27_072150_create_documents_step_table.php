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
        Schema::create('documents_step', function (Blueprint $table) {
            $table->id('step_id');
            $table->integer('document_id');           
            $table->string('name',150)->nullable();    
            $table->integer('group_count');                    
            $table->integer('sort_order');            
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_step');
    }
};
