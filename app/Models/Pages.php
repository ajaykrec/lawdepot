<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $primaryKey = 'page_id';

    function pages_language(){        
        return $this->hasMany('App\Models\Pages_language','page_id','page_id');        
    }
}
