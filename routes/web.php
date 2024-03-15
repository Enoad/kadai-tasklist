<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
/*
// コメント部分は省略

Route::get('/', [TasksController::class, 'index']);
Route::resource('tasks', TasksController::class);

//以下L18

Route::get('/', function () {
    return view('dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



Route::group(['middleware' => ['auth']], function () {                                    // 追記
    Route::resource('tasks', TasksController::class, ['only' => ['index', 'show']]);     // 追記
});       
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function () {
    Route::resource('tasks', TasksController::class, ['only' => ['index', 'show','create','edit','store','update','destroy']]);
    
});