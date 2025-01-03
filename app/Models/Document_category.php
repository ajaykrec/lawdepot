<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_category extends Model
{
    use HasFactory;

    protected $table = 'documents_category';
    protected $primaryKey = 'category_id';

    function document(){         
        return $this->hasMany('App\Models\Document','category_id','category_id');
    }
    function country(){
        return $this->hasOne('App\Models\Country','country_id','country_id');
    }
}
