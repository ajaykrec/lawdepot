<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $primaryKey = 'faq_id';

    function faqs_language(){        
        return $this->hasMany('App\Models\Faq_language','faq_id','faq_id');        
    }
}
