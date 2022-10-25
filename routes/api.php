<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LeadsController;
use App\Http\Controllers\Employee\EmployeeController;

use App\Http\Controllers\Api\CallRecordingController;





Route::any('api-login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::any('saveEmpAttendance',[AttendanceController::class,'saveEmpAttendance']);
    Route::any('getEmpAttendance',[AttendanceController::class,'getAttendance']);
    Route::any('chekTodayEmpAttendance',[AttendanceController::class,'chekTodayEmpAttendance']);
    Route::any('saveEmpCheckout',[AttendanceController::class,'saveEmpCheckout']);

    Route::any('todayActivity',[LeadsController::class,'todayActivity']);
    Route::post('todayCalls',[LeadsController::class,'todayCalls']);
    Route::any('emp-all-leads',[LeadsController::class,'empAllLeads']);

    Route::any('getleadsTemp',[LeadsController::class,'getleadsTemp']);
    Route::any('getTempWiseLeads',[LeadsController::class,'getTempWiseLeads']);
    Route::any('editLeadsRemarks', [LeadsController::class, 'editLeadsRemarks']);


});
//leads Dashboard
Route::any('getleads',[LeadsController::class,'getleads']);
Route::any('search-contact', [LeadsController::class, 'searchContact']);
Route::any('get-lead-detail', [LeadsController::class, 'getLeadDetail']);
Route::any('update-leads-remarks', [LeadsController::class, 'updateLeadsStatus']);
Route::any('getleadsWithParams',[LeadsController::class,'getleadsWithParams']);
Route::any('saveLeadsRemarks',[LeadsController::class,'saveLeadsRemarks']);
Route::any('getAllTemp',[LeadsController::class,'getAllTemp']);
Route::any('getSocialPlatforms',[LeadsController::class,'getSocialPlatforms']);
Route::any('getLeadsInfo',[LeadsController::class,'getLeadsInfo']);
Route::any('getAllCity',[LeadsController::class,'getAllCity']);
Route::any('chek-today-lead-approach',[LeadsController::class,'chekTodayLeadApproach']);

Route::any('getCompanyLocation',[UserController::class,'getCompanyLocation']);
Route::any('resetChekout',[AttendanceController::class,'resetChekout']);
Route::any('/save-call-recording', [CallRecordingController::class, 'callRecording']);

Route::post('postman-add-audio-upload', [UserController::class, 'postmansavepostmansave']);



Route::get('get-approached-leads', [LeadsController::class, 'getApproachedLeads']);
Route::any('delete-approached-leads', [LeadsController::class, 'deleteApprochedLeads']);

Route::any('storeInBoundLeads', [LeadsController::class, 'storeInBoundLeads']);




