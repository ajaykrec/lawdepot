<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers_address extends Model
{
    use HasFactory;

    protected $table = 'customers_address';
    protected $primaryKey = 'address_id';
}
