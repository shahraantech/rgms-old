<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\CoaMapping;
use App\Models\Employee;
use App\Models\Ledger;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $data['clients'] = Client::orderBy('id','DESC')->paginate(10);
        return view('accounts.clients.index', compact('data'));
    }

    public function saveClients(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'contact' => 'required|min:11'

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if (Client::where('name', $request->name)->first()) {
            return response()->json(['error' => 'This client already exist']);
        }

        $amount = $request->input('open_bal');
        $client = new Client();
        $client->name = $request->input('name');
        $client->email = ($request->input('email') ? $request->input('email') : '');
        $client->cnic = ($request->input('cnic')) ? $request->input('cnic') : '';
        $client->contact = $request->input('contact');
        $client->city = $request->input('city');
        $client->customer_group = $request->input('c_group');
        $client->open_bal = ($request->bal_type == 'cr')? $request->input('open_bal') : -abs($request->input('open_bal'));
        $client->address = ($request->input('address')) ? $request->input('address') : '';
        if ($client->save()) {

            $location_id=Employee::getEmpBranchId();
             $data = CoaMapping::getModuleHeadAndLevel('clients');
            //updateHeadBalance
            $head_balance = updateAccountHeadBalance($data['lHeadId'], $amount, 'cr', $data['coa_level']);
            //save transaction
            $trans_id = saveTransaction(0, 'open balance', NULL, NULL, $location_id, $amount, 'Customer Account Open', date('Y-m-d'), $trans_type = 'open balance');

            // save ledger for credits for client
            saveLedger($trans_id->id, $data['lHeadId'], $client->id, 'clients', $request->bal_type, $amount, $client->open_bal, $data['coa_level']);

            return response()->json([
                'status' => 200,
                'message' => 'cleint added successfully',
            ]);
        }
    }


    public function clientDetail(Request $request)
    {
        $data['clients'] = Client::find($request->id);
        return view('accounts.clients.client_detail', compact('data'));
    }

    public function editClient(Request $request)
    {
        $client = Client::find($request->id);
        return $client;
    }


    public function updateClient(Request $request)
    {
        $client = Client::find($request->client_id);

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->cnic = $request->input('cnic');
        $client->contact = $request->input('contact');
        $client->city = $request->input('city');
        $client->open_bal = $request->input('open_bal');
        $client->address = $request->input('address');

        if ($request->hasFile('image')) {
            $path = 'storage/app/public/uploads/accounts/clients/' . $client->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/accounts/clients/', $filename);
            $client->image = $filename;
        }

        $client->save();
        return response()->json([
            'status' => 200,
            'message' => 'client update successfully',
        ]);
    }

    public function deleteClient(Request $request)
    {
        $client_id=$request->id;
        $client = Client::find($client_id);
        if ($client) {
            $path = 'storage/app/public/uploads/accounts/clients/' . $client->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            if ($client->delete()) {
                $res=Ledger::where('ac_type','clients')->where('account_id',$client_id)->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record deleted successfully',
                ]);
            }
        }
    }


    //getClientInfo

    public function getClientInfo(Request $request)
    {
        return $client = Client::find($request->client_id);
    }
}
