<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\RatingsController;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::group(['middleware' =>['auth','can:isTrainer']], function (){

Route::get('/trainer-dashboard', [TrainerController::class, 'dashboard']);
Route::get('/trainee-list', [TrainerController::class, 'traineeList']);
Route::get('/total-trainer', [TrainerController::class, 'totalTrainer']);

Route::get('/trainee-feedback', [RatingsController::class, 'traineeFeedback']);
Route::post('/trainee-feedback', [RatingsController::class, 'saveTraineeFeedback']);
Route::get('/edit-trainee-feedback/{id}', [RatingsController::class, 'editTraineeFeedback']);
Route::post('/update-trainee-feedback/{id}', [RatingsController::class, 'updateTraineeFeedback']);
Route::get('/delete-trainee-feedback/{id}', [RatingsController::class, 'deleteTraineeFeedback']);

Route::get('/getTrainyName', [RatingsController::class, 'getTrainyName']);




});
