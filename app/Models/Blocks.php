<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    use HasFactory;

    protected $table = 'blocks';
    protected $primaryKey = 'block_id';

    function blocks_language(){        
        return $this->hasMany('App\Models\Blocks_language','block_id','block_id');        
    }
}
