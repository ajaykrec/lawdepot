<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';
    protected $primaryKey = 'country_id';

    function language(){
        return $this->hasOne('App\Models\Language','language_id','language_id');
    }
}
