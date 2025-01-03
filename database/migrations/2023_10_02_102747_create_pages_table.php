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
        /*
        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');
            $table->string('name',150);
            $table->string('slug',150)->unique();
            $table->string('banner_image',150);
            $table->text('banner_text')->nullable();            
            $table->text('content')->nullable();
            $table->string('meta_title',255);
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
        */

        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');            
            $table->string('slug',150)->unique();
            $table->string('banner_image',150);           
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
