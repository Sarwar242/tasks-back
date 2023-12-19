<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'api'=>'v1'
    ]);
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/task/create', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/task/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/task/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::put('/task/assign-project/{task}', [TaskController::class, 'assignProject']);
    Route::put('/task/assign-user/{task}', [TaskController::class, 'assignUser']);
    Route::put('/task/remove-user/{task}', [TaskController::class, 'removeUser']);
    Route::put('/task/update-status/{task}', [TaskController::class, 'updateStatus']);
    Route::delete('/task/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Project routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/project/create', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('/project/update/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::put('/project/update-status/{project}', [ProjectController::class, 'updateStatus']);
    Route::delete('/project/delete/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});
