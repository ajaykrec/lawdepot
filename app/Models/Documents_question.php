<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents_question extends Model
{
    use HasFactory;

    protected $table = 'documents_question';
    protected $primaryKey = 'question_id';

    function step(){
        return $this->hasOne('App\Models\Documents_step','step_id','step_id');
    }
    function options(){         
        return $this->hasMany('App\Models\Documents_question_option','question_id','question_id');
    }
    
}
