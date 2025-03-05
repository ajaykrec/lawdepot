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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->integer('invoice_sufix')->nullable();               
            $table->string('invoice_number',50)->nullable();       
            $table->integer('customer_id');
            $table->string('transaction_id',150)->nullable();       
            $table->string('name',150)->nullable()->nullable();       
            $table->string('email',150)->nullable()->nullable();       
            $table->string('phone',50)->nullable()->nullable();       
            
            $table->string('billing_name',150)->nullable();       
            $table->string('billing_company',150)->nullable();            
            $table->string('billing_address',150)->nullable();
            $table->string('billing_city',150)->nullable();            
            $table->string('billing_postcode',50)->nullable();       
            $table->string('billing_country',150)->nullable();
            $table->integer('billing_country_id')->nullable();       
            $table->string('billing_zone',150)->nullable();
            $table->integer('billing_zone_id')->nullable();   
            
            $table->string('shipping_name',150)->nullable();       
            $table->string('shipping_company',150)->nullable();            
            $table->string('shipping_address',150)->nullable();
            $table->string('shipping_city',150)->nullable();            
            $table->string('shipping_postcode',50)->nullable();       
            $table->string('shipping_country',150)->nullable();
            $table->integer('shipping_country_id')->nullable();       
            $table->string('shipping_zone',150)->nullable();
            $table->integer('shipping_zone_id')->nullable();
            
            $table->string('payment_method',150)->nullable();   
            $table->string('shipping_method',150)->nullable(); 
            $table->text('comment')->nullable(); 
            $table->string('ip',150)->nullable();             
            $table->string('currency_code',10)->nullable();  
            $table->decimal('total'); 
            $table->decimal('sub_total'); 
            $table->decimal('discount'); 
            $table->decimal('tax'); 
            $table->decimal('delivery_charge');  
            $table->decimal('commission'); 
            $table->integer('order_status')->comment('0:Pending, 1:Completed, 2:Cancelled');  
            $table->integer('payment_status')->comment('0:Unpaid, 1:Paid');  
            $table->integer('delivery_status')->comment('0:Pending, 1:On the Way, 2:Delivered, 3:Cancelled');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
