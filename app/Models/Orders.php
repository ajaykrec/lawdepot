<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    function orderitems(){
        return $this->hasMany('App\Models\Orders_item','order_id','order_id');
    }
}
