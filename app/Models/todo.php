<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'completed',
    ];

    public $timestamps = true; // Enable timestamps if you want to use created_at and updated_at
}