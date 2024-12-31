<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $quizzes = Quiz::query()->with('questions'); // all();
        if(session('role') !== 'admin'){
            $quizzes = $quizzes->active();
        }
        $quizzes = $quizzes->get();
        return view('pages.admin.quiz.index',compact('quizzes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $quiz = Quiz::find($request->clone);
        return view('pages.admin.quiz.create',compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // dd($request->all());    

        request()->validate([
            'title' => 'required|unique:quizzes',
            'description' => 'required',
            'duration' => 'required',
            'difficulty' => 'required|numeric',
            'status' => 'required',
            // 'slug' => 'required',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required',
            'questions.*.options' => 'required|array|min:4',
            'questions.*.correct_option' => 'required|in:1,2,3,4',  
            'questions.*.points' => 'required|numeric',
            'questions.*.explanation' => 'nullable|string|min:10',
            // 'is_active' => 'required',
        ]);

        $status = 1;
        if(request('status') == 'inactive'){
            $status = 0;
        }

        $slug = Str::slug(request('title'));
        $quiz = Quiz::create([
            'title' => request('title'),
            'description' => request('description'),
            'slug' => $slug,
            'duration' => request('duration',0),
            'difficulty' => request('difficulty',0),
            'is_active' => $status,
        ]);

        foreach (request('questions') as $question) {
            $quiz->questions()->create([
                'question' => $question['question'],
                'options' => json_encode($question['options']),
                'correct_option' => $question['correct_option'],
                'points' => $question['points'],
                'explanation' => $question['explanation'],
            ]);
        }

        return redirect()->route('admin.quiz.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $quiz = Quiz::find($id);
        return view('pages.admin.quiz.edit',compact('quiz'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'title' => 'required|unique:quizzes,title,'.$id,
            'description' => 'required',
            'duration' => 'required',
            'difficulty' => 'required|numeric',
            // 'slug' => 'required',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required',
            'questions.*.options' => 'required|array|min:4',
            'questions.*.correct_option' => 'required|in:1,2,3,4',  
            // 'is_active' => 'required',
        ]);

        $slug = Str::slug(request('title'));
        $quiz = Quiz::find($id);
        $quiz->update([
            'title' => request('title'),
            'description' => request('description'),
            'slug' => $slug,
            'duration' => request('duration',0),
            'difficulty' => request('difficulty',0),
            'is_active' => request('is_active',1),
        ]);

        $quiz->questions()->delete();

        foreach (request('questions') as $question) {
            $quiz->questions()->create([
                'question' => $question['question'],
                'options' => json_encode($question['options']),
                'correct_option' => $question['correct_option'],
                'points' => 1,
            ]);
        }

        return redirect()->route('admin.quiz.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::find($id);
        $quiz->delete();

        return redirect()->route('admin.quiz.index');
    }



    public function show(string $slug)
    {
        //
        $quiz = Quiz::where('slug', $slug)->first();
        return view('pages.quiz.show',compact('quiz'));

    }

    public function start(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $quiz = Quiz::find($request->quiz_id);
        $start = $quiz->start();

        return response()->json([
            'message' => 'Quiz started successfully',
            'start' => $start,
        ]);

    }

    public function submit(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $quiz = Quiz::find($request->quiz_id);
        $quiz->stop(); 

        $points = 0;
        foreach ($request->answers as $answer) {
            $question = $quiz->questions()->find($answer['question_id']);
            if ($question->correct_option == $answer['answer']) {
                $points += $question->points;
            }
        }

        QuizSubmission::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->user()->id,
            'answers' => json_encode($request->answers),
            'points' => $points,
        ]);

        return response()->json([
            'message' => 'Quiz Submitted successfully',
            'status' => true,
            'time_used' => '2 Minutes',
            'total_points' => $points,
            'questions' => $quiz->questions()->get(),
        ]);

    }
}
