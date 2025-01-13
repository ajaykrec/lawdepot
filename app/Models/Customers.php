<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    function address(){
        return $this->hasMany('App\Models\Customers_address','customer_id','customer_id');
    }
}
