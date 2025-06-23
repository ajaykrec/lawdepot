<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers_guest_document extends Model
{
    use HasFactory;

    protected $table = 'customers_guest_document';
    protected $primaryKey = 'guest_document_id';

    function document(){
        return $this->hasOne('App\Models\Document','document_id','document_id');
    }
}
