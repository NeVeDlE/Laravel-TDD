<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::resource('projects', ProjectsController::class);
    Route::post('/projects/', [ProjectsController::class, 'store']);
    Route::post('/projects/{project:id}/tasks', [ProjectTasksController::class, 'store']);
    Route::patch('/projects/{project:id}/tasks/{task:id}', [ProjectTasksController::class, 'update']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
