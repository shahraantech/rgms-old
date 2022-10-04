<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AccountantHomeController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Vendor::all();
        return view('accounts.vendors.index', compact('vendor'));
    }


    public function saveVendor(Request $request)
    {

        if ($request->isMethod('post')) {
            $vendor = new Vendor();
            $vendor->name = $request->input('name');
            $vendor->email = $request->input('email');
            $vendor->cnic = $request->input('cnic');
            $vendor->contact = $request->input('contact');
            $vendor->city = $request->input('city');
            $vendor->open_bal = $request->input('open_bal');
            $vendor->address = $request->input('address');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('storage/app/public/uploads/accounts/vendor/', $filename);
                $vendor->image = $filename;
            }

            $vendor->save();
            return response()->json([
                'status' => 200,
                'message' => 'vendor added successfully',
            ]);
        }
    }

    public function editVendor($id)
    {
        $vendor = Vendor::find($id);
        if ($vendor) {
            return response()->json([
                'status' => 200,
                'vendor' => $vendor
            ]);
        }
    }

    public function updateVendor(Request $request)
    {

        $vendor = Vendor::find($request->hidden_vendor_id);
        $vendor->vendor_name = $request->input('vendor_name');
        $vendor->contact = $request->input('contact');
        $vendor->website = $request->input('website');
        $vendor->focal_person = $request->input('focal_person');

        if ($request->hasFile('image')) {
            $path = 'public/assets/img/vendor/' . $vendor->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/assets/img/vendor/', $filename);
            $vendor->image = $filename;
        }

        $vendor->update();
        return response()->json([
            'status' => 200,
            'message' => 'Vendor Update Successfully',
        ]);
    }

    public function deleteVendor(Request $request)
    {
        $vendor = Vendor::find($request->id);
        if ($vendor) {
            $path = 'public/assets/img/vendor/' . $vendor->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $vendor->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Vendor Deleted Successfully',
            ]);
        }
    }
}
