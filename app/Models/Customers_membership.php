<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers_membership extends Model
{
    use HasFactory;

    protected $table = 'customers_membership';
    protected $primaryKey = 'cus_membership_id';

    function membership(){
        return $this->hasOne('App\Models\Membership','membership_id','membership_id');
    }
}
