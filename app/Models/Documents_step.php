<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents_step extends Model
{
    use HasFactory;

    protected $table = 'documents_step';
    protected $primaryKey = 'step_id';

    function document(){
        return $this->hasOne('App\Models\Document','document_id','document_id');
    }
    function questions(){         
        return $this->hasMany('App\Models\Documents_question','step_id','step_id');
    }    
}
