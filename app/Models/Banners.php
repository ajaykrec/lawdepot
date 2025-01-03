<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $table = 'banners';
    protected $primaryKey = 'banner_id';
    
    function bannercat(){
        //=== one to one relationship
        //return $this->hasOne('App\Models\Banners_category','bannercat_id','bannercat_id');
        //=== one to many relationship
        //return $this->hasMany('App\Models\Banners_category','bannercat_id','bannercat_id');

        return $this->hasOne('App\Models\Banners_category','bannercat_id','bannercat_id');
    }
    function banners_language(){        
        return $this->hasMany('App\Models\Banners_language','banner_id','banner_id');        
    }
   
}
