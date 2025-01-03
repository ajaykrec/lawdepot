<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'document_id';

    function country(){
        return $this->hasOne('App\Models\Country','country_id','country_id');
    }
    function category(){
        return $this->hasOne('App\Models\Document_category','category_id','category_id');
    }
    function steps(){         
        return $this->hasMany('App\Models\Documents_step','document_id','document_id');
    }
}
