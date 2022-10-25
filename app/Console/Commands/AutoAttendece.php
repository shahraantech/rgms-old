<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Console\Command;

class AutoAttendece extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:attend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employee = Employee::get();
        $current_date = date('Y-m-d');
        foreach ($employee as $val) {
            $attt = Attendance::where('emp_id', $val->id)->where('date', $current_date)->first();
            if (isset($attt)) {
                \Log::info('Attendance Already');
            } else {
                $att = new Attendance();
                $att->emp_id = $val->id;
                $att->status = '0';
                $att->date = date('Y-m-d');
                $att->attendance_date = $attDay = date('d', strtotime(date('Y-m-d')));
                $att->attendance_month = date('m', strtotime(date('Y-m-d')));
                $att->attendance_year = date('Y', strtotime(date('Y-m-d')));
                $att->marked_by = 'admin';
                $att->guard = 'web';
                $att->save();
                \Log::info('Attendance Successfully');
            }
        }
    }
}
