<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_type extends Model
{
    use HasFactory;

    protected $table = 'users_types';
    protected $primaryKey = 'usertype_id';
}
