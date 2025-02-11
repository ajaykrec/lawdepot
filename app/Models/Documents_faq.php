<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents_faq extends Model
{
    use HasFactory;

    protected $table = 'documents_faq';
    protected $primaryKey = 'dfaq_id';

    function step(){
        return $this->hasOne('App\Models\Documents_step','step_id','step_id');
    }    
    
}
