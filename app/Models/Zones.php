<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zones extends Model
{
    use HasFactory;

    protected $table = 'zones';
    protected $primaryKey = 'zone_id';

    function country(){
        return $this->hasOne('App\Models\Country','country_id','country_id');
    }
}
