
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\HelpDeskController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;

Auth::routes();



Route::group(['middleware' => ['auth', 'can:isEmployee']], function () {

    Route::get('/employee-dashboard', [EmployeeController::class, 'dashboard']);

    Route::get('/employeeMail/{id}', [EmployeeController::class, 'employeeMail']);
    Route::get('/emp-reset-password/{token}/{email}', [EmployeeController::class, 'empResetPassword']);

    //leave routes
    Route::get('leaves', [LeaveController::class, 'index']);
    Route::post('leaves', [LeaveController::class, 'saveLeaveRequest']);
    Route::get('edit-leaves', [LeaveController::class, 'editLeaves']);
    Route::post('update-leaves', [LeaveController::class, 'updateLeaves']);
    Route::get('delete-leaves/{id}', [LeaveController::class, 'deleteLeaves']);



    Route::get('/getReminingLeaves', [LeaveController::class, 'getRemainingLeaves']);
    Route::get('/getLeavesList', [LeaveController::class, 'getLeavesList']);
    Route::get('/resignation', [ResignationController::class, 'index']);
    Route::post('/resignation', [ResignationController::class, 'saveResignation']);
    Route::get('/resignationList', [ResignationController::class, 'resignationList']);
    Route::get('/edit-resignation', [ResignationController::class, 'editResignation']);
    Route::post('/update-resig', [ResignationController::class, 'updateResig']);
    Route::get('/delete-resig/{id}', [ResignationController::class, 'deleteResig']);
    Route::get('/help-desk', [HelpDeskController::class, 'index']);
    Route::post('/save-ticket', [HelpDeskController::class, 'saveTicket']);
    Route::get('/edit-ticket', [HelpDeskController::class, 'editTicket']);
    Route::post('/update-ticket', [HelpDeskController::class, 'upateTicket']);
    Route::get('/delete-ticket/{id}', [HelpDeskController::class, 'deleteTicket']);
    Route::get('/my-ticket', [HelpDeskController::class, 'myTicket']);


    //ExpensesController
    Route::get('/expenses', [ExpensesController::class, 'index']);
    Route::get('/my-targets', [TargetController::class, 'myTargets']);
    Route::get('/manager-targets', [TargetController::class, 'managerTargets']);
    Route::any('/assign-target/{target_id}', [TargetController::class, 'assignTarget']);
    Route::any('/save-assign-target', [TargetController::class, 'saveAssignTarget']);
    Route::any('/team-target/{target_id}', [TargetController::class, 'teamTarget']);
    Route::get('edit-team-target', [TargetController::class, 'editTeamTarget']);
    Route::post('update-team-target', [TargetController::class, 'updateTeamTarget']);
    Route::get('delete-team-target', [TargetController::class, 'deleteTeamTarget']);
    Route::get('/emp-trainings', [TrainingController::class, 'empTrainings']);
    Route::get('/trainer-feedback', [RatingsController::class, 'index']);
    Route::post('/trainer-feedback', [RatingsController::class, 'saveTrainerFeedBack']);
    Route::any('/write-feedback', [RatingsController::class, 'writeFeedback']);
    Route::get('/rating-test', [RatingsController::class, 'ratingTest']);
    Route::get('/getTrainerName', [RatingsController::class, 'getTrainerName']);
    Route::get('/my-expenses', [ExpensesController::class, 'myExpenses']);
    Route::post('/my-expenses', [ExpensesController::class, 'saveMyExpenses']);
    Route::get('/getMyExpenseList', [ExpensesController::class, 'getMyExpenseList']);
    Route::get('/edit-expense', [ExpensesController::class, 'editExpense']);
    Route::post('/update-expense', [ExpensesController::class, 'updateExpense']);
    Route::get('/delete-expense/{id}', [ExpensesController::class, 'deleteExpense']);

    Route::get('/my-tasks', [TasksController::class, 'myTasks']);

    Route::get('/my-projects', [TasksController::class, 'myProjects']);

    Route::post('/save-tasks', [TasksController::class, 'saveTasks']);
    Route::post('/newSaveTasks', [TasksController::class, 'newSaveTasks']);

    Route::get('/edit-tasks', [TasksController::class, 'editTasks']);
    Route::post('/update-tasks', [TasksController::class, 'updateTasks']);
    Route::get('/delete-tasks/{id}', [TasksController::class, 'deleteTasks']);

    Route::get('/get-task-list', [TasksController::class, 'getTaskList']);


    Route::get('/getMySingleTask', [TasksController::class, 'getMySingleTask']);

    Route::get('/updatee-project-status', [TasksController::class, 'updateProjectStatus']);
    Route::get('/update-task-status', [TasksController::class, 'updateTaskStatus']);
    Route::post('/save-task-progress', [TasksController::class, 'saveTaskProgress']);
    Route::get('/project-details/{id}', [TasksController::class, 'projectDetails']);


    Route::any('create-daily-task', [TasksController::class, 'createDailyTask']);
    Route::any('saveCreateDailyTask', [TasksController::class, 'saveCreateDailyTask']);
    Route::any('mark-sub-task', [TasksController::class, 'markSubTask']);
    Route::get('emp-tasks/{id}', [TasksController::class, 'empTask']);

    Route::get('/editNewtask', [TasksController::class, 'editNewtask']);
    Route::post('/updateNewtask', [TasksController::class, 'updateNewtask']);
    Route::get('/deleteNewtask', [TasksController::class, 'deleteNewtask']);


    Route::get('my-daily-task', [TasksController::class, 'MyDailyTask']);
    Route::get('/getMyDailySingleTask', [TasksController::class, 'getMyDailySingleTask']);
    Route::post('/storeMyDailySingleTask/{id}', [TasksController::class, 'storeMyDailySingleTask']);

});


Route::post('emp-password-update', [EmployeeController::class, 'empPasswordUpdate']);
