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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');      
            $table->string('stripe_customer_id',100)->nullable();      
            $table->string('name',150)->nullable();
            $table->string('email',150)->unique();
            $table->string('phone',32)->unique();
            $table->string('password',150)->nullable();
            $table->string('auth_provider',100)->nullable();
            $table->string('auth_uid',150)->nullable();
            $table->string('profile_photo',150)->nullable();
            $table->date('dob')->nullable();
            $table->integer('login_status');
            $table->string('remember_token',150)->nullable();                       
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
