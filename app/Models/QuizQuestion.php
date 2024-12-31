<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    //

    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id',
        'question',
        'options',
        'correct_option',
        'points',
        'explanation',
    ];

    // getAttribute for options json decode
    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
