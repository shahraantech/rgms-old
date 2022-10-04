<?php

namespace App\Models;

use App\Console\Commands\LeadCron;
use App\Imports\EmailImport;
use App\Jobs\SendEmailToLead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class Lead extends Model
{
    use HasFactory;

    public static function  getManagers()
    {
        return $res = Lead::join('employees', 'employees.id', 'leads.leader_id')
            ->select('leads.leader_id', 'employees.name')
            ->where('employees.status', 1)
            ->get();
    }

}
