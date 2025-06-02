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
        Schema::create('customers_membership', function (Blueprint $table) {
            $table->id('cus_membership_id');   
            $table->integer('customer_id');   
            $table->integer('membership_id');  
            $table->integer('order_id');
            $table->integer('document_id');  
            $table->date('start_date')->nullable();       
            $table->date('end_date')->nullable();       
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_membership');
    }
};
