<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingDate extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'rating',
        'description',
        'date'
    ];
}
