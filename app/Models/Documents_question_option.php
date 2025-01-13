<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents_question_option extends Model
{
    use HasFactory;

    protected $table = 'documents_question_option';
    protected $primaryKey = 'option_id';
    
    function question(){
        return $this->hasOne('App\Models\Documents_question','question_id','question_id');
    }

    function questions(){         
        return $this->hasMany('App\Models\Documents_question','option_id','option_id');
    }
    
}
