<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Expense;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use Yoeunes\Toastr\Facades\Toastr;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->isMethod('get')) {
            return Company::all();
        }
        return view('admin.company.index');
    }

    //addCompany

    public function addCompany(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = array(
                'company_name' => 'required',
                'working_days' => 'required',
                'allow_holidays' => 'required',
                'address' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()->all()]);
            }


            if ($request->hasFile('file')) {

                //upload logo
                $uniqueid = uniqid();
                $original_name = $request->file('file')->getClientOriginalName();
                $size = $request->file('file')->getSize();
                $extension = $request->file('file')->getClientOriginalExtension();
                $name = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                $imagepath = url('/storage/uploads/expense-bills/' . $name);
                $path = $request->file('file')->storeAs('public/uploads/company-assets/', $name);

                //upload favicon
                $uniqueid = uniqid();
                $original_name = $request->file('favicon')->getClientOriginalName();
                $size = $request->file('favicon')->getSize();
                $extension = $request->file('favicon')->getClientOriginalExtension();
                $fav = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                $imagepath = url('/storage/uploads/expense-bills/' . $name);
                $path = $request->file('favicon')->storeAs('public/uploads/company-assets/', $fav);

                $comp = new Company();
                $comp->name = $request->company_name;
                $comp->logo = $name;
                $comp->favicon = $fav;
                $comp->working_days = $request->working_days;
                $comp->allow_holidays = $request->allow_holidays;
                $comp->lat = $request->lat;
                $comp->lang = $request->lang;
                $comp->address = $request->address;

                if ($comp->save()) {

                    return response()->json(['success' => 'Record saved successfully'], 200);
                } else {
                    return response()->json(['error' => 'Record not saved'], 200);
                }
            }
        }

        return view('admin.company.company');
    }

    public function editCompany($id)
    {
        $comp = Company::find($id);
        return view('admin.company.edit-company', compact('comp'));
    }


    public function updateCompany(Request $request)
    {

        $comp = Company::find($request->id);

        $comp->name = $request->company_name;
        $comp->working_days = $request->working_days;
        $comp->allow_holidays = $request->allow_holidays;
        $comp->lat = $request->lat;
        $comp->lang = $request->lang;
        $comp->address = $request->address;

        if ($request->hasFile('favicon')) {
            $path = 'storage/app/public/uploads/company-assets/' . $comp->favicon;
            if (File::exists($path)) {
                File::delete($path);
            }
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('favicon');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/company-assets/', $filename);
            $comp->favicon = $filename;
        }

        if ($request->hasFile('logo')) {
            $path1 = 'storage/app/public/uploads/company-assets/' . $comp->logo;
            if (File::exists($path1)) {
                File::delete($path1);
            }
            $file_second = $request->file('logo');
            $extension_second = $file_second->getClientOriginalExtension();
            $filename_second = time() . '.' . $extension_second;
            $file_second->move('storage/app/public/uploads/company-assets/', $filename_second);
            $comp->logo = $filename_second;
        }

        if ($comp->update()) {
            return redirect('company');
        }
    }

    public function deleteCompany(Request $request)
    {
        $comp = Company::find($request->id);
        $path = 'storage/app/public/uploads/company-assets/' . $comp->favicon;
        $path1 = 'storage/app/public/uploads/company-assets/' . $comp->logo;
        if (File::exists($path)) {
            File::delete($path);
        }
        if (File::exists($path1)) {
            File::delete($path1);
        }
        $comp->delete();
        return response()->json([
            'status' => 200,
            'message' => 'company deleted Successfully',
        ]);
    }

    //companyBranch

    public function companyBranch()
    {
        return view('admin.company.branch');
    }

    //addCompanyBranch

    public function addCompanyBranch(Request $request)
    {

        $data['company'] = Company::all();

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = array(
                'company_id' => 'required',
                'branch_name' => 'required',
                'f_person' => 'required',
                'phone' => 'required',
                'address' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()]);
            }

            $comp = new CompanyBranch();
            $comp->company_id = $request->company_id;
            $comp->branch_name = $request->branch_name;
            $comp->focal_person = $request->f_person;
            $comp->contact = $request->phone;
            $comp->lat = $request->lat;
            $comp->lang = $request->lang;
            $comp->address = $request->address;

            if ($comp->save()) {

                return response()->json(['success' => 'Record saved successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not saved'], 200);
            }
        }


        return view('admin.company.add-company-branch')->with(compact('data'));
    }

    //getCompanyBranches

    public function getCompanyBranches()
    {
        return $data = CompanyBranch::with('companyname')->orderByDesc('id')->get();
    }

    public function editCompanyBranches(Request $request)
    {
        $comp_branch = CompanyBranch::find($request->id);
        $company = Company::all();
        return view('admin.company.edit-company-branch', get_defined_vars());
    }

    public function updateCompanyBranches(Request $request)
    {
        $comp = CompanyBranch::find($request->id);
        $comp->company_id = $request->company_id;
        $comp->branch_name = $request->branch_name;
        $comp->focal_person = $request->f_person;
        $comp->contact = $request->phone;
        $comp->lat = $request->lat;
        $comp->lang = $request->lang;
        $comp->address = $request->address;

        if ($comp->update()) {

            return redirect('company-branches')->with('success', 'Company Branch update Successfully');
        } else {
            return back()->with('error', 'Error');
        }
    }

    public function deleteCompanyBranches(Request $request)
    {
        $comp_branch = CompanyBranch::find($request->id);
        if ($comp_branch->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'company branch deleted Successfully',
            ]);
        }
    }
}
