<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// GET|HEAD        api/tasks ................ tasks.index › TaskController@index
// POST            api/tasks ................ tasks.store › TaskController@store
// GET|HEAD        api/tasks/create ......... tasks.create › TaskController@create
// GET|HEAD        api/tasks/{task} ......... tasks.show › TaskController@show
// PUT|PATCH       api/tasks/{task} ......... tasks.update › TaskController@update
// DELETE          api/tasks/{task} ......... tasks.destroy › TaskController@destroy
// GET|HEAD        api/tasks/{task}/edit .... tasks.edit › TaskController@edit

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/tasks', TaskController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('/projects', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
