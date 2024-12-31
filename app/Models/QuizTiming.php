<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizTiming extends Model
{
    //

    protected $fillable = [
        'quiz_id',
        'user_id',
        'start_time',
        'strop_time',
    ];

    public function quiz() { 
        return $this->belongsTo(Quiz::class); 
    }
}
