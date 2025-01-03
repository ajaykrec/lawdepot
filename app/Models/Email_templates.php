<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email_templates extends Model
{
    use HasFactory;

    protected $table = 'email_templates';
    protected $primaryKey = 'email_template_id';
}
