<?php

namespace App\Http\Controllers;
use App\Event\InterviewScheduled;
use Mail;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use DB;


class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //sendMail
    public function sendMail125()
    {

        $name = "Salman";
        $to_name = 'Salman Raza';
        $id = 1;
        $to_email = 'salmanrazabwn@gmail.com';

        $data = array("name" => $name, "body" => "Please click this button for active your account", "h5" => $id);
        Mail::send("email", $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject("Reply to your query");
            $message->from("dbsoft686@gmail.com", "ALpha HRM");
        });
    }
    public function sendMail()
    {

        $details = [
            'title' => 'Alpha HRM',
            'body' => 'It is testing Alpha HRM Mail',
            'name' => 'Salman Raza'
        ];

        Mail::to('salmanrazabwn@gmail.com')->send(new \App\Mail\SendMail($details));

        dd("Email is Sent.");
    }

    //googleCalender
    public function googleCalender()
    {
        $event = new Event;
        $event->name = 'A new event';
        $event->startDateTime = Carbon::now();
        $event->endDateTime = Carbon::now()->addHour();
        $event->save();
    }

    public function alterTableName(){
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            foreach ($table as $key => $value)
                echo $value .'</br>';
            $tableName=$value;
            $resuts = DB::select("ALTER TABLE $tableName ADD COLUMN IF NOT EXISTS mh INT NULL DEFAULT NULL AFTER id;");


        }

    }
}
