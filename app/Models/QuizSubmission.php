<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    //

    protected $fillable = [
        'quiz_id',
        'user_id',
        'answers',
        'points',
    ];
}
