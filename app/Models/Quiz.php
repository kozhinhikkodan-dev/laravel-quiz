<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //

    protected $table = 'quizzes';

    protected $fillable = ['title', 'description', 'slug', 'is_active', 'duration', 'difficulty', 'status'];

    // scrop active
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function start(){
        return $this->timings()->create([
            'user_id' => auth()->user()->id,
            'start_time' => now(),
        ]);
    }

    public function GetStartedOnAttribute(){
        $timing = QuizTiming::where('quiz_id', $this->id)->where('user_id', auth()->user()->id)
        ->latest()->first();

        if ($timing && $timing->start_time) {
            $startTime = \Carbon\Carbon::parse($timing->start_time);
            return $startTime->diffForHumans();
        }

        return null;
    }

    public function stop(){
        $timing = QuizTiming::where('quiz_id', $this->id)->where('user_id', auth()->user()->id)
        ->latest()->first();

        $timing->stop_time = now();
        $timing->save();

        return $timing;
    }

    public function timings()
    {
        return $this->hasMany(QuizTiming::class);
    }

    public function submission()
    {
        return $this->hasMany(related: QuizSubmission::class)->where('user_id', auth()->user()->id)->latest()->first();
    }

    public function getTimeUsedAttribute()
    {

        $timing = $this->timings()->where('user_id', auth()->user()->id)->latest()->first();
        if ($timing && $timing->stop_time && $timing->start_time) {
            $stopTime = \Carbon\Carbon::parse($timing->stop_time);
            $startTime = \Carbon\Carbon::parse($timing->start_time);
            return $startTime->longAbsoluteDiffForHumans($stopTime, 3);
        }
        return null;
    }

    public function getAverageCompletionTimeAttribute()
    {
        $timings = $this->timings()->whereNotNull('stop_time')->get();
        if ($timings->isEmpty()) {
            return null;
        }

        $totalTime = $timings->reduce(function ($carry, $timing) {
            $stopTime = \Carbon\Carbon::parse($timing->stop_time);
            $startTime = \Carbon\Carbon::parse($timing->start_time);
            return $carry + $startTime->diffInSeconds($stopTime);
        }, 0);

        $averageTimeInSeconds = $totalTime / $timings->count();
        $averageTime = \Carbon\CarbonInterval::seconds($averageTimeInSeconds)->cascade();

        return $averageTime->forHumans(['parts' => 3]);
    }


    public function getScoreAttribute()
    {
        $submission = $this->submission();
        return  $submission ? $submission->points : 0;
    }

    public function getResultAttribute()
    {
       $submission = $this->submission();
       if(!$submission) return null;
       $submissionAnswers = collect(json_decode($submission->answers));
      
       $result = [];

       foreach ($this->questions as $key => $question) {
        $result[$key]['question_id'] = $question->id;

        $userAnswer = $submissionAnswers->firstWhere('question_id', $question->id)?->answer;

        $result[$key]['answers'] = $userAnswer;
        $result[$key]['is_correct'] = 2; // not attempted
        if ($userAnswer) {
            if ($question->correct_option == $userAnswer) {
                $result[$key]['is_correct'] = 1; // correct
            } else {
                $result[$key]['is_correct'] = 0; // wrong
            }
        }


       }

       return (object) [
        'result' => $result,
        'score' => $submission->points,
        'total_score' => $this->questions->sum('points'),
        'total_questions' => $this->questions->count(),
        'user_answers' => $submissionAnswers,
        'attended_questions_count' => count($submissionAnswers),
        'right_answers_count' => collect($result)->where('is_correct', 1)->count(),
        'wrong_answers_count' => collect($result)->where('is_correct', 0)->count(),
        'not_attempted_questions_count' => collect($result)->where('is_correct', 2)->count(),
        'time_used' => $this->getTimeUsedAttribute(),
    ];
           

    }
}
