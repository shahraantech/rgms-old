<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Http\Gates\HrGate;
use App\Http\Gates\EmployeeGate;
use App\Http\Gates\TrainerGate;
use App\Http\Gates\AdminGate;
use App\Http\Gates\AccountsGate;
use App\Http\Gates\CallCenterGate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
         Gate::define('isHR',[HrGate::class,'checkHr']);
         Gate::define('isEmployee',[EmployeeGate::class,'employeeGate']);
         Gate::define('isTrainer',[TrainerGate::class,'checkTrainer']);
         Gate::define('isAdmin',[AdminGate::class,'adminGate']);
         Gate::define('isAccountant',[AccountsGate::class,'accountGate']);
         Gate::define('isCallCenterAgent',[CallCenterGate::class,'callcenterGate']);

        //
    }
}
