<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

// コメント部分は省略

Route::get('/', [TasksController::class, 'index']);
Route::resource('tasks', TasksController::class);



Route::get('/', function () {
    return view('dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';