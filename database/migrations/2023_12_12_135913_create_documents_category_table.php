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
        Schema::create('documents_category', function (Blueprint $table) {
            $table->id('category_id');
            $table->integer('parent_id');
            $table->integer('country_id');
            $table->string('name',150)->nullable();
            $table->string('slug',150)->nullable();
            $table->string('image',150)->nullable();   
            $table->string('banner_image',150)->nullable();   
            $table->text('banner_text')->nullable();                
            $table->text('content')->nullable();           
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
        Schema::dropIfExists('documents_category');
    }
};
