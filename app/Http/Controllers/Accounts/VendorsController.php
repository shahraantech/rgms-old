<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\CoaMapping;
use App\Models\Employee;
use App\Models\Vendor;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VendorsController extends Controller
{
    // public function index(){
    //     return $res=getVendorsNameForDropdown();
    // }

    public function index(Request $request)
    {
        $data['vendor'] = Vendor::OrderBy('id','DESC')->paginate(10);
        return view('accounts.vendors.index', compact('data'));
    }
    public function getVendorsName()
    {
       return $res=getVendorsNameForDropdown();
    }


    public function saveVendor(Request $request)
    {
         $data = $request->all();
         $rules = array(
            'contact' => 'required');
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if (Vendor::where('name', $request->name)->first()) {
            return response()->json([ 'error' => 'This vendor already exist']);
        }
            $amount=$request->input('open_bal');
            $location_id=Employee::getEmpBranchId();
            $vendor = new Vendor();
            $vendor->name = $request->input('name');
            $vendor->v_group = $request->input('v_group');
            $vendor->email = ($request->input('email')) ? $request->input('email') : '';
            $vendor->fp_name = $request->input('fp_name');
            $vendor->contact = $request->input('contact');
            $vendor->city = 'Lahore';//$request->input('city');
            $vendor->open_bal = ($request->bal_type == 'cr') ?$request->input('open_bal'): -abs($request->input('open_bal'));
            $vendor->address = ($request->input('address')) ? $request->input('address') : '';
            if ($vendor->save()) {

                $data=CoaMapping::getModuleHeadAndLevel('vendors');

                //updateHeadBalance
                $head_balance = updateAccountHeadBalance($data['lHeadId'], $amount, $request->bal_type,$data['coa_level']);

                //save transaction
                $trans_id=saveTransaction(0,'open balance',NULL,NULL,$location_id,$amount,'Vendor Account Open',date('Y-m-d'),$trans_type='open balance');

                // save ledger for credits for client
                saveLedger($trans_id->id,$data['lHeadId'],$vendor->id,'vendors',$request->bal_type,$amount,$vendor->open_bal,$data['coa_level']);



                return response()->json([
                    'status' => 200,
                    'message' => 'vendor added successfully',
                ]);
            }
        }
    public function vendorDetail(Request $request)
    {
        $data['vendor'] = Vendor::find($request->id);
        return view('accounts.vendors.vendor_detail', compact('data'));
    }

    public function editVendor(Request $request)
    {
        $vendor = Vendor::find($request->id);
        return $vendor;
    }

    public function updateVendor(Request $request)
    {
        $vendor = Vendor::find($request->vendor_id);

        $vendor->name = $request->input('name');
        $vendor->email = $request->input('email');
        $vendor->cnic = $request->input('cnic');
        $vendor->contact = $request->input('contact');
        $vendor->city = $request->input('city');
        $vendor->open_bal = $request->input('open_bal');
        $vendor->address = $request->input('address');

        if ($request->hasFile('image')) {
            $path = 'storage/app/public/uploads/accounts/vendor/'.$vendor->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/accounts/vendor/', $filename);
            $vendor->image = $filename;
        }

        $vendor->save();
        return response()->json([
            'status' => 200,
            'message' => 'vendor update successfully',
        ]);
    }

    public function deleteVendor(Request $request)
    {
        $vendor = Vendor::find($request->id);
        if ($vendor) {
            $path = 'storage/app/public/uploads/accounts/vendor/' . $vendor->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $vendor->delete();
            return response()->json([
                'status' => 200,
                'message' => 'vendor deleted successfully',
            ]);
        }
    }

    //getClientsName
    public function getClientsName(){
        return $res=getClientsNameForDropdown();
    }


    //getAccountsName
    public function getAccountsName(Request  $request){

        if($request->ac_type=='vendors'){
            $res=Vendor::all();
        }

        if($request->ac_type=='clients' OR $request->ac_type=='customers'){
            $res=Client::all();
        }
        return $res;
    }
}
