<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_item extends Model
{
    use HasFactory;
    protected $table = 'orders_items';
    protected $primaryKey = 'orderitem_id';
}
