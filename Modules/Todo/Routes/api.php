<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->name('api::')->group(function () {
    Route::apiResource('todos', TodoApiController::class);
    Route::post('todos/{todo_id}/check', 'TodoApiController@checkOrUncheck');
});
