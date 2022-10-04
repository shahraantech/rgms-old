<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Models\Customer_servey;
use App\Models\CustomerServey;
use App\Models\Loged_history;
use App\Models\Quatation;
use App\Models\Servey_remarks;
use App\Models\ServeyRemarks;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    public function index()
    {
        $qus = Quatation::all();
        return view('quotation.index', get_defined_vars());
    }

    public function getQuotation()
    {
        $vendors = Vendor::all();
        return view('quotation.view', get_defined_vars());
    }

    public function storeQuotation(Request $request)
    {
        $qutation = Vendor::where('id', $request->vendor_id)->first();
        $vemail = $qutation->email;

        $data = [
            'vendor_id' => $request->vendor_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to($vemail)->send(new NotifyMail($data));

        $savedata = new Quatation();
        $savedata->vendor_id = $data['vendor_id'];
        $savedata->subject = $data['subject'];
        $savedata->message = $data['message'];
        $savedata->save();
        return back()->with('success', 'Email Send Successfully');
    }

    public function loginHistory()
    {
        $log_history = Loged_history::orderBy('id', 'desc')->paginate(10);
        return view('admin.loginhistory', get_defined_vars());
    }


    public function customerServay()
    {
        $cs = Customer_servey::all();
        return view('admin.customer-servay', get_defined_vars());
    }

    public function servayRmarks($id)
    {
        $srmarks = Customer_servey::find($id);
        return view('admin.servay-remarks', get_defined_vars());
    }

    public function storeServayRmarks(Request $request)
    {
        $sr = new Servey_remarks();
        $sr->servey_id = $request->servey_id;
        $sr->age = $request->age;
        $sr->address = $request->address;
        $sr->is_married = $request->is_married;
        $sr->profession = $request->profession;
        $sr->intrest = $request->intrest;
        $sr->is_dependent = $request->is_dependent;
        $sr->remarks = $request->remarks;
        $sr->save();

        if ($sr->save()) {
            return back()->with('success', 'servey remarks added successfully');
        }

    }
}
