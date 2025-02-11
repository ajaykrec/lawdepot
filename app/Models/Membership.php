<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'membership';
    protected $primaryKey = 'membership_id';

    function country(){         
        return $this->hasOne('App\Models\Country','country_id','country_id');
    }
}
