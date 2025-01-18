<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'creation_date'
    ];
}
