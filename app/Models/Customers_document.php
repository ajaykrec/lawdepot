<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers_document extends Model
{
    use HasFactory;

    protected $table = 'customers_document';
    protected $primaryKey = 'cus_document_id';

    function document(){
        return $this->hasOne('App\Models\Document','document_id','document_id');
    }
}
