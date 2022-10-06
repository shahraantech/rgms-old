<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallCenter\PostsController;
use App\Http\Controllers\CallCenter\CallCenterLeadsController;
use App\Http\Controllers\CallCenter\CompaginController;
use App\Http\Controllers\CallCenter\TempratureController;
use App\Http\Controllers\CallCenter\StaffController;
use App\Http\Controllers\CallCenter\CityController;
use App\Http\Controllers\CallCenter\PropertyController;

use App\Http\Controllers\CallCenter\PlatformController;
use App\Http\Controllers\CallCenter\DealController;
use App\Http\Controllers\Accounts\SaleController;
use App\Http\Controllers\CustomerSurvey;





use App\Http\Controllers\Accounts\AccountsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;

Route::group(['middleware' =>['auth','can:isCallCenterAgent']], function (){

//vendor routes
Route::any('posts', [PostsController::class, 'index']);
Route::any('create-post', [PostsController::class, 'createPost']);

Route::any('get-comment', [CallCenterLeadsController::class, 'getComment']);

Route::any('leads', [CallCenterLeadsController::class, 'index']);
Route::any('store-leads', [CallCenterLeadsController::class, 'storeLeeds']);

Route::any('leads-list', [CallCenterLeadsController::class, 'leadsList']);
Route::any('open-leads', [CallCenterLeadsController::class, 'openLeads']);
Route::any('manager-leads', [CallCenterLeadsController::class, 'managerLeads']);

Route::any('inOutBoundleadsList/{id}', [CallCenterLeadsController::class, 'inOutBoundleadsList']);
Route::any('allocated-leads', [CallCenterLeadsController::class, 'allocatedLeads']);
Route::any('manager-allocated-leads', [CallCenterLeadsController::class, 'managerAllocatedLeads']);
// Route::any('getLeads', [CallCenterLeadsController::class, 'getLeads']);
Route::get('editLeeds/{id}', [CallCenterLeadsController::class, 'editLeeds']);
Route::post('updateLeeds', [CallCenterLeadsController::class, 'updateLeeds']);
Route::get('deleteLeeds/{id}', [CallCenterLeadsController::class, 'deleteLeeds']);
Route::post('import-leads', [CallCenterLeadsController::class, 'importLeads'])->name('import-leads');

Route::get('export-leads', [CallCenterLeadsController::class, 'exportLeads'])->name('export-leads');
Route::any('deleteLeads', [CallCenterLeadsController::class, 'deleteLeads']);
Route::any('customeAssignLeads', [CallCenterLeadsController::class, 'customeAssignLeads']);
Route::any('managerToCsrLeadsAssign', [CallCenterLeadsController::class, 'managerToCsrLeadsAssign']);
Route::any('csrToManagerLeadsAssign', [CallCenterLeadsController::class, 'csrToManagerLeadsAssign']);
Route::any('saveMeetings', [CallCenterLeadsController::class, 'saveMeetings']);

    //leads for employee
    Route::any('my-leads', [CallCenterLeadsController::class, 'myLeads']);
    Route::any('my-approached-leads', [CallCenterLeadsController::class, 'myApproachedLeads']);
    Route::any('leads-params/{type}/{sender}', [CallCenterLeadsController::class, 'leadsParams']);
    Route::any('leads-temp-wise/{sender}/{temp_id}/{temp_name}', [CallCenterLeadsController::class, 'leadsTempWise']);
    Route::any('getLeadsAcordingSocilaPlatforms', [CallCenterLeadsController::class, 'getLeadsAcordingSocilaPlatforms']);

    Route::any('editLeadsInfo', [CallCenterLeadsController::class, 'editLeadsInfo']);
    Route::any('update-leads-status', [CallCenterLeadsController::class, 'updateLeadsStatus']);

    Route::any('save-leads-status', [CallCenterLeadsController::class, 'saveLeadRemarks']);
    Route::any('lead-detail/{id}', [CallCenterLeadsController::class, 'leadDetail']);
    Route::any('qa-feedback', [CallCenterLeadsController::class, 'qaFeedback']);
    Route::any('meet-detail/{id}', [CallCenterLeadsController::class, 'meetdDetail']);
    Route::any('leads-settings', [CallCenterLeadsController::class, 'leadSettings']);
    Route::any('update-leads-settings', [CallCenterLeadsController::class, 'updateLeadsSettings']);
    Route::any('leads-source-settings', [CallCenterLeadsController::class, 'leadsSourceSettings']);
    Route::any('update-source-leads-settings', [CallCenterLeadsController::class, 'updateSourceLeadsSettings']);
    Route::any('get_responsed_leads', [CallCenterLeadsController::class, 'get_responsed_leads']);

    Route::any('csr-no-of-leads', [CallCenterLeadsController::class, 'csrNoOfLeads']);
    Route::any('csr-leads/{agent_id}/{from_date}/{to_date}', [CallCenterLeadsController::class, 'csrLeads']);
    Route::any('manager-no-of-leads', [CallCenterLeadsController::class, 'managerNoOfLeads']);
    Route::any('leads-response', [CallCenterLeadsController::class, 'leadsResponse']);
    Route::any('leads-analysis', [CallCenterLeadsController::class, 'leadsAnalysis']);
    Route::any('sales-report', [CallCenterLeadsController::class, 'salesReport']);
    Route::any('get-sale-report', [CallCenterLeadsController::class, 'getSalesReport']);
    Route::any('dead-lead-report', [CallCenterLeadsController::class, 'deadLeadReport']);
    Route::any('get-dead-lead-report', [CallCenterLeadsController::class, 'getDeadLeadReport']);
    Route::any('calls-qa-report', [CallCenterLeadsController::class, 'callsQaReport']);

    Route::get('create-record', [CallCenterLeadsController::class, 'createRecord']);
    Route::post('store-record', [CallCenterLeadsController::class, 'storeRecord']);


    Route::any('staff', [StaffController::class, 'index']);
    Route::any('getTestTemp', [StaffController::class, 'getTestTemp']);




    //leads for employee end here

    //compagins here
    Route::any('email', [CompaginController::class, 'email']);
    Route::post('email-send', [CompaginController::class, 'emailSend']);

    Route::get('email-attachment', [CompaginController::class, 'emailAttachment']);

    // Route::post('email-send-attachments',[CompaginController::class, 'emailSendAttachments']);

    Route::post('email-send-attachments',[CompaginController::class, 'emailSendAttachments']);

    Route::any('sms', [CompaginController::class, 'sms']);



Route::any('meetings', [DealController::class, 'index']);
Route::any('my-meetings', [DealController::class, 'myMeetings']);
Route::any('my-sales', [DealController::class, 'mySales']);
Route::any('sales-list', [DealController::class, 'salesLists']);
Route::any('manager-meetings', [DealController::class, 'managerMeetings']);
Route::any('pushed-meetings', [DealController::class, 'pushedMeetings']);

//sale with lead
Route::any('sale-to-lead/{id}', [SaleController::class, 'saleToLead']);
Route::any('customer-form/{id}', [SaleController::class, 'customerForm']);
Route::any('save-customer-form', [SaleController::class, 'customerFormSave']);

Route::any('walkin-customer', [SaleController::class, 'walkinCustomer']);
Route::any('walkin-customer-list', [SaleController::class, 'walkinCustomerList']);

// deleteable
Route::any('updateAllLeadStatusWhichAreApprocache', [CallCenterLeadsController::class, 'updateAllLeadStatusWhichAreApprocache']);


Route::get('property-type', [PropertyController::class, 'propertyType']);
Route::get('get-property-type', [PropertyController::class, 'getPropertyType']);
Route::post('store-property-type', [PropertyController::class, 'storePropertyType']);
Route::get('edit-property-type', [PropertyController::class, 'editPropertyType']);
Route::post('update-property-type', [PropertyController::class, 'updatePropertyType']);
Route::get('delete-property-type', [PropertyController::class, 'deletePropertyType']);

Route::any('property-variation', [PropertyController::class, 'propertyVariation']);
Route::get('get-property-variation', [PropertyController::class, 'getpropertyVariation']);
Route::get('edit-property-variation', [PropertyController::class, 'editPropertyVariation']);
Route::post('update-property-variation', [PropertyController::class, 'updatePropertyVariation']);
Route::get('delete-property-variation', [PropertyController::class, 'deletePropertyVariation']);

Route::any('property-projects', [PropertyController::class, 'propertyProjects']);
Route::any('get-property-projects', [PropertyController::class, 'getPropertyProjects']);
Route::post('property-projects-store', [PropertyController::class, 'propertyProjectsStore']);
Route::get('property-projects-edit', [PropertyController::class, 'propertyProjectsEdit']);
Route::post('property-projects-update', [PropertyController::class, 'propertyProjectsUpdate']);
Route::get('property-projects-delete', [PropertyController::class, 'propertyProjectsDelete']);


Route::get('property', [PropertyController::class, 'Property']);
Route::any('create-property', [PropertyController::class, 'createProperty']);

Route::get('property-edit', [PropertyController::class, 'propertyEdit']);
Route::post('property-update', [PropertyController::class, 'propertyUpdate']);
Route::get('property-delete', [PropertyController::class, 'propertyDelete']);

Route::get('get-property-base-variation', [PropertyController::class, 'getPropertyBaseVariation']);
// Route::get('get-property', [PropertyController::class, 'getProperty']);

Route::any('get-seller', [PropertyController::class, 'getSeller']);
Route::any('get-buyer', [PropertyController::class, 'getBuyer']);
Route::get('get-seller-buyer-detail', [PropertyController::class, 'sellerBuyerDetail']);

Route::get('status-update', [PropertyController::class, 'statusUpdate']);


Route::get('create-survey', [CustomerSurvey::class, 'index']);
Route::post('import-customer-survey', [CustomerSurvey::class, 'importCustomerSurvey'])->name('import-customer-survey');
Route::any('view-survey-remarks/{id}', [CustomerSurvey::class, 'viewCustomerSurvey']);


    Route::get('customer-survey', [CustomerSurvey::class, 'customerServay']);
    Route::get('survey-remarks/{id}', [CustomerSurvey::class, 'servayRmarks']);
    Route::post('store-servay-remarks', [CustomerSurvey::class, 'storeServayRmarks']);

    Route::any('not-intrested/{id}', [CustomerSurvey::class, 'notIntrested']);
    Route::any('not-connected/{id}', [CustomerSurvey::class, 'notConnected']);

});
