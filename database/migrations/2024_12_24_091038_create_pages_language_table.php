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
        Schema::create('pages_language', function (Blueprint $table) {
            $table->integer('page_id');
            $table->integer('language_id');
            $table->primary(['page_id','language_id']);
            $table->string('name',150); 
            $table->text('banner_text')->nullable();            
            $table->text('content')->nullable();
            $table->string('meta_title',255);
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages_language');
    }
};
