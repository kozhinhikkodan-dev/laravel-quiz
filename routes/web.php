<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransalationController;
use App\Models\Translation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register.page');
Route::post('/register',[AuthController::class,'registerProcess'])->name('register');
Route::post('/login',[AuthController::class,'loginProcess'])->name('login.process');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register',[AdminAuthController::class,'register'])->name('register.page');
Route::post('/register',[AdminAuthController::class,'registerProcess'])->name('register');
Route::get('/logout',[AdminAuthController::class,'logout'])->name('logout');

});

Route::prefix('admin')->as('admin.')->group(function () {
    Route::resource('quiz', App\Http\Controllers\QuizController::class);
});

// Route::middleware('auth.any')->get('/', function () {
//     return view('home');
// })->name('home');


Route::middleware('auth.any')->group(function () {
   Route::get('/quiz/{slug}', [App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
   Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
   Route::get('/', [DashboardController::class, 'dashboard'])->name('home');

   Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

});


Route::middleware('auth')->group(function () {
    Route::post('/quiz/start', [App\Http\Controllers\QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/submit', [App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');

 });


Route::get('lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    $user = session('user');
    if(!$user)
    {
        return redirect()->route('logout');
    }
    $user->lang = $lang;
    $user->save();
    return redirect()->back();
})->name('language');

// new route to trans-store/{lang}/{key}/{value}
Route::post('trans-store', [TransalationController::class, 'store'])->name('trans-store');
Route::get('translations', [TransalationController::class, 'index'])->name('translations.index');
Route::get('translations/list', [TransalationController::class, 'list'])->name('translations.list.index');
Route::delete('translations/destroy/{id}', [TransalationController::class, 'destroy'])->name('translations.destroy');
