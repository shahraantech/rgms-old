<?php

namespace App\Http\Controllers\CallCenter;

use App\Console\Commands\LeadCron;
use App\Http\Controllers\Controller;
use App\Imports\EmailImport;
use App\Jobs\SendEmailToLead;
use App\Mail\SendMailToAllLeads;
use App\Models\City;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadsMarketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class CompaginController extends Controller
{
    //email
    public function email(Request $request)
    {

        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname')->orderByDesc('id');

        if ($request->isMethod('post')) {

            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->where('city_id', $city_id);
            });
        }

        $leads = $qry->paginate(10);

        $cities = City::all();
        return view('call-center.compagin.email', get_defined_vars());
    }

    // public function emailSend(Request $request)
    // {
    //     $details = [
    //         'title' => 'The A Team',
    //         'body' => 'Trainings',
    //     ];


    //     $details['email'] = 'zaeemasif1123@gmail.com';

    //     dispatch(new SendEmailToLead($details));

    //     return 'done';
    // }

    public function emailAttachment(Request $request)
    {
        return view('call-center.compagin.email_attachment');
    }

    public function emailSendAttachments(Request $request)
    {
        $input = $request->validate([
            'attachment' => 'required',
        ]);

        Excel::import(new EmailImport, request()->file('file'));

        $path = public_path('uploads/mail/');
        $attachment = $request->file('attachment');
        $name = time() . '.' . $attachment->getClientOriginalExtension();;
        // create folder
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $attachment->move($path, $name);

        $filename = $path . '/' . $name;
        $details['subject'] = $request->subject;
        $details['text_body'] = $request->text_body;

        $res = dispatch(new SendEmailToLead($details, $filename));
        if ($res) {
            return redirect()->back()->with('success', 'Mail sent successfully.');
        }
    }

    //sms
    public function sms(Request $request)
    {
        return view('call-center.compagin.sms');
    }
}
