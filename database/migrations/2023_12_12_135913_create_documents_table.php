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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->integer('country_id');
            $table->integer('category_id');
            $table->string('name',200)->nullable();
            $table->string('slug',200)->nullable();
            $table->text('short_description')->nullable();
            $table->text('openai_system_content')->nullable();
            $table->text('openai_user_content')->nullable();
            $table->text('description')->nullable(); 
            $table->text('template')->nullable(); 
            $table->string('image',200)->nullable();  
            $table->string('meta_title',255)->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
