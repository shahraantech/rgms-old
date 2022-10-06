<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recruitments;
use App\Http\Controllers\Departments;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\HelpDeskController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\CallCenter\CityController;
use App\Http\Controllers\CallCenter\PlatformController;
use App\Http\Controllers\CallCenter\RoleController;
use App\Http\Controllers\CallCenter\TempratureController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\QuotationController;


Auth::routes();




Route::group(['middleware' => ['auth', 'can:isAdmin']], function () {

    Route::get('/recruitment/existing', [Recruitments::class, 'existing']);
    Route::get('/existingList', [Recruitments::class, 'existingList']);


    Route::get('/departments', [Departments::class, 'departments']);
    Route::post('/save-department', [Departments::class, 'saveDepartment']);
    Route::any('/get-department', [Departments::class, 'getDepartment']);

    Route::any('/getDeptRespectToCompany', [Departments::class, 'getDeptRespectToCompany']);

    Route::any('/edit-department', [Departments::class, 'editDepartment']);
    Route::any('/update-department', [Departments::class, 'updateDepartment']);
    Route::any('/delete-department', [Departments::class, 'deleteeDepartment']);


    Route::any('/recruitment/new', [Recruitments::class, 'newHiring']);
    Route::get('/edit-recruitment/{id}', [Recruitments::class, 'editRecruitment']);
    Route::any('/update-recruitment', [Recruitments::class, 'updateRecruitment']);
    Route::any('/recruitment/new/form', [Recruitments::class, 'newHiringForm']);
    Route::post('/save-new/hiring', [Recruitments::class, 'saveNewHiring']);
    Route::any('/get-new/hiring', [Recruitments::class, 'getNewHiring']);
    Route::get('/delete/recruitment', [Recruitments::class, 'deleteRecruitment']);


    Route::get('/getApplicantsList', [JobsController::class, 'getApplicantsList']);
    Route::get('/download-resume/{id}', [JobsController::class, 'downloadResume']);
    Route::any('/job-applicants', [JobsController::class, 'applicants']);
    Route::any('/update-applicant-status', [JobsController::class, 'updateApplicantStatus']);


    Route::post('/save-interview', [InterviewController::class, 'saveInterview']);
    Route::any('/interviews', [InterviewController::class, 'interviews']);
    Route::get('/reshedule-interview', [InterviewController::class, 'resheduleInterview']);
    Route::post('/update-interview', [InterviewController::class, 'updateInterview']);


    Route::any('/employees', [EmployeeController::class, 'index']);

    Route::get('update-employee-status', [EmployeeController::class, 'updateEmployeeStatus']);

    Route::any('/employees-list', [EmployeeController::class, 'employeeList']);
    Route::get('/new-employee', [EmployeeController::class, 'newEmployee']);
    Route::post('/new-employee', [EmployeeController::class, 'saveNewEmployee']);

    Route::any('/delete-employee', [EmployeeController::class, 'deleteEmployee']);

    Route::any('/designation', [DesignationController::class, 'index']);
    Route::any('/designationList', [DesignationController::class, 'designationList']);
    Route::post('/save-desig', [DesignationController::class, 'saveDesig']);
    Route::get('/delete-designation', [DesignationController::class, 'deleteDesignation']);
    Route::get('/edit-designation', [DesignationController::class, 'editDesignation']);
    Route::get('/update-desig', [DesignationController::class, 'updateDesignation']);


    Route::get('/policies', [OnboardingController::class, 'index']);
    Route::get('/create-policies', [OnboardingController::class, 'createPolicies']);
    Route::post('/create-policies', [OnboardingController::class, 'savePolicies']);
    Route::any('/delete-polciy/{id}', [OnboardingController::class, 'deletePolicies']);
    Route::any('/edit-polciy/{id}', [OnboardingController::class, 'editPolicies']);
    Route::any('/update-polciy', [OnboardingController::class, 'updatePolicies']);

    Route::any('/getEmpByCompany', [OnboardingController::class, 'getEmpByCompany']);
    Route::any('/getLocationOnTheBaseOfCompany', [OnboardingController::class, 'getLocationOnTheBaseOfCompany']);



    Route::get('/offer-letter', [OnboardingController::class, 'offerLetter']);
    Route::get('/offer-letter-create/{emp_id}', [OnboardingController::class, 'createOfferLetter']);

    Route::get('/exp-letter', [LetterController::class, 'expLetter']);
    Route::get('/letter-create/{emp_id}', [LetterController::class, 'createLetter']);

    Route::get('/clearance-letter', [LetterController::class, 'clearanceLetter']);
    Route::get('/clearance-letter-create/{emp_id}', [LetterController::class, 'createClearanceLetter']);




    Route::get('/grades', [GradesController::class, 'index']);
    Route::get('/grades-list', [GradesController::class, 'gradesList']);
    Route::post('/grades', [GradesController::class, 'saveGrade']);
    Route::get('/delete-grade', [GradesController::class, 'deleteGrade']);
    Route::get('/edit-grade', [GradesController::class, 'editGrade']);
    Route::post('/update-grade', [GradesController::class, 'updateGrade']);



    Route::get('/time', [TimeController::class, 'index']);
    Route::post('/save-times', [TimeController::class, 'saveTimes']);
    Route::get('/get-times', [TimeController::class, 'getTimes']);
    Route::get('/delete-time', [TimeController::class, 'deleteTimes']);
    Route::get('/edit-time', [TimeController::class, 'editTimes']);
    Route::post('/update-time', [TimeController::class, 'updateTimes']);


    Route::get('/att-dashboard', [AttendanceController::class, 'attDashboard']);
    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::post('/attendance', [AttendanceController::class, 'markAttendance']);
    Route::any('/view-attendance', [AttendanceController::class, 'viewAttendance']);
    Route::get('/edit-attendance', [AttendanceController::class, 'editAttendance']);
    Route::get('/update-attendance', [AttendanceController::class, 'updateAttendance']);
    Route::any('/attendance-reports', [AttendanceController::class, 'attendanceReports']);
    Route::any('single-emp-att-mark', [AttendanceController::class, 'singleEmpAttMark']);


    Route::any('/resignations', [ResignationController::class, 'resignationsListForHr']);
    Route::any('/resignationListData', [ResignationController::class, 'resignationListData']);
    Route::get('/update-resignation', [ResignationController::class, 'updateResignation']);

    Route::any('/ticket', [HelpDeskController::class, 'ticket']);
    Route::get('/ticket-list', [HelpDeskController::class, 'ticketList']);
    Route::get('/update-ticket-status', [HelpDeskController::class, 'updateTicketStatus']);

    //ExpensesController
    Route::any('/expense', [ExpensesController::class, 'index']);
    Route::get('/update-expense-status', [ExpensesController::class, 'updateExpenseStatus']);


    Route::get('/trainings', [TrainingController::class, 'index']);
    Route::post('/trainings', [TrainingController::class, 'saveTrainings']);
    Route::get('/edit-trainings', [TrainingController::class, 'editTrainings']);
    Route::any('/update-trainings', [TrainingController::class, 'updateTrainings']);
    Route::get('/delete-trainings/{id}', [TrainingController::class, 'deleteTrainings']);


    Route::get('/trainers', [TrainerController::class, 'index']);
    Route::get('/trainersList', [TrainerController::class, 'trainersList']);
    Route::post('/trainers', [TrainerController::class, 'saveTrainers']);
    Route::get('/edit-trainers', [TrainerController::class, 'editTrainers']);
    Route::post('/update-trainers', [TrainerController::class, 'updateTrainers']);
    Route::get('/delete-trainers/{id}', [TrainerController::class, 'deleteTrainers']);

    Route::get('/trainer-reviews', [RatingsController::class, 'trainerReviews']);
    Route::get('/emp-reviews', [RatingsController::class, 'empReviews']);


    Route::any('/tasks', [TasksController::class, 'index']);
    Route::any('/projects', [TasksController::class, 'projects']);
    Route::post('/projects', [TasksController::class, 'saveProjects']);
    Route::get('/edit-projects/{id}', [TasksController::class, 'editProjects']);
    Route::post('/update-projects/{id}', [TasksController::class, 'upadateProjects']);
    Route::get('/delete-projects/{id}', [TasksController::class, 'deleteProjects']);


    Route::get('/get-manager-data', [TasksController::class, 'getManagerData']);

    Route::get('/task-details/{id}', [TasksController::class, 'taskDetailsForTaskBoard']);


    //payrolls
    Route::any('/salary', [PayrollController::class, 'index']);
    Route::get('/view-salary-slip/{month}/{year}/{id}', [PayrollController::class, 'salarySlip']);
    Route::get('update-salary-slip', [PayrollController::class, 'paySalary']);
    Route::get('/payroll-items', [PayrollController::class, 'payrollItems']);
    Route::post('/payroll-items', [PayrollController::class, 'saveAllowance']);
    Route::get('/edit-allowance', [PayrollController::class, 'editAllowance']);
    Route::get('/update-allowance', [PayrollController::class, 'updateAllowance']);
    Route::get('/delete-allowance/{id}', [PayrollController::class, 'deleteAllowance']);

    Route::any('salary-sheet', [PayrollController::class, 'salarySheet']);
    Route::any('dept-wise-salary-report', [PayrollController::class, 'deptWiseSalaryReport']);

    //Leads Management
    Route::any('team', [LeadsController::class, 'index']);
    Route::get('edit-leeds/{id}', [LeadsController::class, 'editLeeds']);
    Route::post('update-leeds/{id}', [LeadsController::class, 'udpateLeeds']);


    //company management
    Route::any('company', [CompanyController::class, 'index']);
    Route::any('add-company', [CompanyController::class, 'addCompany']);
    Route::get('edit-company/{id}', [CompanyController::class, 'editCompany']);
    Route::post('update-company/{id}', [CompanyController::class, 'updateCompany']);
    Route::get('delete-company/{id}', [CompanyController::class, 'deleteCompany']);


    Route::any('company-branches', [CompanyController::class, 'companyBranch']);
    Route::any('add-company-branch', [CompanyController::class, 'addCompanyBranch']);
    Route::any('get-company-branches', [CompanyController::class, 'getCompanyBranches']);
    Route::get('edit-company-branches/{id}', [CompanyController::class, 'editCompanyBranches']);
    Route::post('update-company-branches/{id}', [CompanyController::class, 'updateCompanyBranches']);
    Route::get('delete-company-branches', [CompanyController::class, 'deleteCompanyBranches']);


    Route::any('countEmpSalary', [PayrollController::class, 'countEmpSalary']);

    Route::any('leaves-settings', [LeaveController::class, 'leavesSettings']);

    Route::any('off-week', [LeaveController::class, 'offWeek']);
    Route::get('edit-off-week', [LeaveController::class, 'editOffWeek']);
    Route::post('update-off-week', [LeaveController::class, 'updateOffWeek']);
    Route::get('delete-off-week', [LeaveController::class, 'deleteOffWeek']);


    Route::get('get-empoyee-company-base', [LeaveController::class, 'getEmpoyeeCompanyBase']);
    Route::post('off-week-store', [LeaveController::class, 'offWeekStore']);

    Route::get('get-leaves-settings', [LeaveController::class, 'getLeavesSettings']);
    Route::get('edit-leaves-settings', [LeaveController::class, 'editLeavesSettings']);
    Route::get('update-leaves-settings', [LeaveController::class, 'updateLeavesSettings']);
    Route::get('delete-leaves-settings/{id}', [LeaveController::class, 'deleteLeavesSettings']);

    Route::post('add-company-leaves', [LeaveController::class, 'AddCompanyLeave']);
    Route::get('edit-company-leaves', [LeaveController::class, 'editCompanyLeave']);
    Route::get('update-company-leaves', [LeaveController::class, 'udpateCompanyLeave']);
    Route::get('delete-company-leaves/{id}', [LeaveController::class, 'deleteCompanyLeaves']);



    Route::any('leaves-request', [LeaveController::class, 'leavesRequest']);
    Route::any('update-leave-request', [LeaveController::class, 'updateLeaveRequest']);
    // Users
    Route::get('users-role-change', [UserController::class, 'changeRole']);
    Route::any('update-user-role', [RoleController::class, 'updateUserRole']);
    Route::any('change-user-status', [RoleController::class, 'changeUserStatus']);
    Route::any('change-user-status/{user_id}/{status}', [UserController::class, 'changeUserStatus']);
    Route::any('society', [SocietyController::class, 'index']);
    Route::any('society-list', [SocietyController::class, 'societyList']);

    Route::any('city', [CityController::class, 'index']);
    Route::get('edit-city', [CityController::class, 'editCity']);
    Route::post('update-city', [CityController::class, 'updateCity']);
    Route::get('delete-city', [CityController::class, 'deleteCity']);

    Route::any('platforms', [PlatformController::class, 'index']);
    Route::any('platforms-store', [PlatformController::class, 'PlatformsStore']);
    Route::any('platforms-list', [PlatformController::class, 'platformsList']);
    Route::get('platforms-edit', [PlatformController::class, 'platformsEdit']);
    Route::post('platforms-update', [PlatformController::class, 'platformsUpdate']);
    Route::get('platforms-delete', [PlatformController::class, 'platformsDelete']);
    Route::any('cityList', [CityController::class, 'cityList']);

    Route::any('temp', [TempratureController::class, 'index']);
    Route::get('temp-list', [TempratureController::class, 'tempList']);
    Route::get('edit-temp', [TempratureController::class, 'editTemp']);
    Route::post('update-temp', [TempratureController::class, 'updateTemp']);

    Route::any('monthly-att-report', [AttendanceController::class, 'monthlyAttReport']);
    Route::any('daily-att-report', [AttendanceController::class, 'dailyAttReport']);
    Route::any('checkout-report', [AttendanceController::class, 'checkoutReport']);


    //Company Assets Routes
    Route::get('assets', [AssetController::class, 'index']);
    Route::get('get-assets', [AssetController::class, 'getAssets']);
    Route::post('store-assets', [AssetController::class, 'storeAssets']);
    Route::get('edit-assets', [AssetController::class, 'editAssets']);
    Route::post('update-assets', [AssetController::class, 'updateAssets']);
    Route::get('delete-assets', [AssetController::class, 'deleteAssets']);


    Route::get('create-specification', [AssetController::class, 'createSpecification']);
    Route::post('store-specification', [AssetController::class, 'storeSpecification']);
    Route::get('edit-specification', [AssetController::class, 'editSpecification']);
    Route::post('update-specification', [AssetController::class, 'updateSpecification']);
    Route::get('delete-specification', [AssetController::class, 'deleteSpecification']);


    Route::get('specification/{id}', [AssetController::class, 'Specification']);


    Route::get('add-specification', [AssetController::class, 'addSpecification']);
    Route::get('getSpecificationBaseAsset', [AssetController::class, 'getSpecificationBaseAsset']);
    Route::post('store-add-specification', [AssetController::class, 'storeAddSpecification']);

    Route::get('edit-asset-specification', [AssetController::class, 'editAssetSpecification']);


    Route::get('asign-assets', [AssetController::class, 'assignAssets']);
    Route::get('get-asign-assets', [AssetController::class, 'getAsignAssets']);
    Route::post('store-asign-assets', [AssetController::class, 'storeAsignAssets']);
    Route::get('edit-asign-assets', [AssetController::class, 'editAsignAssets']);
    Route::post('update-asign-assets', [AssetController::class, 'updateAsignAssets']);
    Route::get('delete-asign-assets', [AssetController::class, 'deleteAsignAssets']);


    Route::get('quotation', [QuotationController::class, 'index']);
    Route::get('get-quotation', [QuotationController::class, 'getQuotation']);
    Route::post('store-quotation', [QuotationController::class, 'storeQuotation']);

    Route::get('login-history', [QuotationController::class, 'loginHistory']);


    Route::get('customer-servay', [QuotationController::class, 'customerServay']);
    Route::get('servay-remarks/{id}', [QuotationController::class, 'servayRmarks']);
    Route::post('store-servay-remarks', [QuotationController::class, 'storeServayRmarks']);
});

Route::get('audio-upload', [EmployeeController::class, 'audioupload']);
Route::any('get-current-location', [UserController::class, 'getCurrentLocation']);
