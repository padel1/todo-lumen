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

    public $timestamps = true; 
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}