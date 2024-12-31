<?php

namespace App\Http\Controllers;

use App\Models\QuizTiming;

abstract class Controller
{
    //

    public function dashboard(){
        return view('pages.dashboard');
    }

    public function profile(){
        $quizTimings = QuizTiming::where('user_id', session('user.id'))->get();
        // dd($quizTiming);
        return view('pages.profile',compact('quizTimings'));
    }
}
