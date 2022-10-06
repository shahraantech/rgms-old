<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Accounts\VendorsController;
use App\Http\Controllers\Accounts\BuilderController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\CallCenter\ChatController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CallCenter\RoleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CallCenter\CallCenterLeadsController;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PayPalController;



//Project Routes
//
Auth::routes(['verify' => true]);


Route::group(['middleware' =>['auth']], function () {
    Route::get('/my-profile', [ProfileController::class, 'index'])->middleware('auth');
    // change password
    Route::post('change-password',  [ProfileController::class,'changePassword']);

    Route::get('/user-profile/{id}', [ProfileController::class, 'userProfile']);


    Route::post('store-education', [ProfileController::class, 'storeEducation']);
    Route::post('store-experience', [ProfileController::class, 'storeExperience']);
    Route::post('store-certification', [ProfileController::class, 'storeCertification']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

    Route::get('/edit-employee/{id}', [EmployeeController::class, 'editEmployee']);
    
    Route::post('/update-employee', [EmployeeController::class, 'updateEmployee']);



    Route::get('get-vendors-name', [VendorsController::class, 'getVendorsName']);
    Route::get('get-clients-name', [VendorsController::class, 'getClientsName']);
    Route::get('get-buildings', [BuilderController::class, 'getBuildings']);

    Route::get('chat', [ChatController::class, 'index']);


    //target routs
    Route::any('/targets', [TargetController::class, 'index']);
    Route::get('/targetList', [TargetController::class, 'targetList']);
    Route::get('edit-targets', [TargetController::class, 'editTargets']);
    Route::post('update-targets', [TargetController::class, 'updateTargets']);
    Route::get('delete-targets', [TargetController::class, 'deleteTargets']);
    Route::get('tanveer', [AttendanceController::class, 'tanveer']);

    // Route::get('/edit-targets/{id}', [TargetController::class, 'editTargets']);
    // Route::post('/update-targets/{id}', [TargetController::class, 'updateTargets']);
    // Route::get('/delete-targets/{id}', [TargetController::class, 'deleteTargets']);


// get designation
    Route::any('/getDesignations', [DesignationController::class, 'getDesignations']);
    // getEmployeeBaseDesignation
    Route::any('/getEmployeeBaseDesignation', [OnboardingController::class, 'getEmployeeBaseDesignation']);
    Route::any('/getEmployeesBaseofCompanyId', [EmployeeController::class, 'getEmployeesBaseofCompanyId']);
    Route::any('/countNotification', [NotificationController::class, 'countNotification']);
    Route::any('/countMessage', [NotificationController::class, 'countMessage']);
    Route::any('/getEmpInfo', [EmployeeController::class, 'getEmpInfo']);
    Route::any('/getUsers', [UserController::class, 'getUsers']);
    Route::any('/update-user-status', [UserController::class, 'updateUserStatus']);
    Route::any('users', [RoleController::class, 'roleAssign']);
    Route::post('user-store', [RoleController::class, 'userStore']);
    Route::any('create-user', [RoleController::class, 'roleAssign']);
    Route::any('update-role-has-permissions', [RoleController::class, 'updateRoleHasPermissions']);
    Route::any('/emp-attendance', [AttendanceController::class, 'empAttendance']);
    Route::any('/mark-emp-attendance', [AttendanceController::class, 'markEmpAttendance']);
    Route::any('/getChekOutTime', [AttendanceController::class, 'getChekOutTime']);
    Route::get('/call-recording', [RoleController::class, 'callRecording']);

    Route::any('getLeadsInfo', [CallCenterLeadsController::class, 'getLeadsInfo']);

    //deleteable
    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

    Route::get('/paypal', function () {

        return view('paypal');

    });

//paypal-call

    Route::post('paypal', [PaypalController::class,'paypal']);
    Route::post('paypal-call', [PaypalController::class,'index'])->name('paypal_call');
    Route::any('paypal-return', [PaypalController::class,'paypalReturn'])->name('paypal_return');
    Route::any('paypal-cancel', [PaypalController::class,'paypalCancel'])->name('paypal_cancel');

});

Route::get('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/job/list', [JobsController::class, 'jobList']);
Route::get('/job/view/{id}', [JobsController::class, 'jobView']);
Route::post('/apply-job', [JobsController::class, 'applyJob']);
Route::get('/check-job-applied', [JobsController::class, 'checkJobApplied']);
Route::get('/ajax-autocomplete-search', [HelperController::class, 'ajaxEmpAutoSearch'])->middleware('auth');
//Project Routes End Here
Route::any('roles', [RoleController::class, 'index']);
Route::get('roles-list', [RoleController::class, 'rolesList']);
Route::any('role-permissions', [RoleController::class, 'rolePermissions']);
Route::any('test-permissions', [RoleController::class, 'testPermissions']);

Route::get('calender', [CalendarController::class, 'index']);
Route::get('verify-account/{id}',[UserController::class, 'verifyAccount']);


Route::post('full-calender/action', [CalendarController::class, 'action']);

Route::get('alterTableName',[TestController::class, 'alterTableName']);


