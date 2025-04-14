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
        Schema::create('documents_question', function (Blueprint $table) {
            $table->id('question_id');
            $table->integer('document_id');      
            $table->integer('step_id');      
            $table->integer('option_id');   
            $table->string('label',150)->nullable();  
            $table->string('short_question',255)->nullable();           
            $table->text('question')->nullable();
            $table->text('quick_info')->nullable();  
            $table->text('description')->nullable();                  
            $table->string('placeholder',255)->nullable();    
            $table->string('answer_type',50)->nullable()->comment('text, textarea, dropdown, radio, checkbox, date, image, file');   
            $table->tinyInteger('display_type')->comment('0:vertical, 1:horizontal');   
            $table->string('field_name',150)->nullable();   
            $table->integer('label_group');
            $table->integer('blank_space');            
            $table->tinyInteger('is_add_another')->comment('0:No, 1:Yes');  
            $table->integer('add_another_max');   
            $table->string('add_another_text',150)->nullable(); 
            $table->string('add_another_button_text',150)->nullable();                   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_question');
    }
};
