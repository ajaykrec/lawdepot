<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners_category extends Model
{
    use HasFactory;

    protected $table = 'banners_categories';
    protected $primaryKey = 'bannercat_id';

    function banners(){ 
        //=== one to many relationship
        return $this->hasMany('App\Models\Banners','bannercat_id','bannercat_id');
    }
}
