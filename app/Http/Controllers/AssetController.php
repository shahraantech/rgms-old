<?php

namespace App\Http\Controllers;

use App\Models\Asign_asset;
use App\Models\Asset;
use App\Models\Create_specification;
use App\Models\Employee;
use App\Models\Specification;
use App\Models\Specification_value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\Specificity;

class AssetController extends Controller
{
    public function index()
    {
        return view('company-assets.index');
    }

    public function getAssets(Request $request)
    {
        $assets = Asset::all();
        return $assets;
    }

    public function storeAssets(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $asset = new Asset();
        $asset->title = $request->title;
        $asset->save();

        return back()->with('success', 'Assets added successfully');
    }

    public function editAssets(Request $request)
    {
        $asset = Asset::find($request->id);
        return response()->json([
            'asset' => $asset,
        ]);
    }

    public function updateAssets(Request $request)
    {
        $asset = Asset::find($request->asset_id);
        $asset->title = $request->title;
        $asset->update();

        return back()->with('success', 'Assets updated successfully');
    }

    public function deleteAssets(Request $request)
    {
        $asset = Asset::find($request->id);
        if ($asset->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Asset Deleted Successfully',
            ]);
        }
    }

    public function assignAssets()
    {
        $employees = Employee::all();
        $assets = Asset::all();
        return view('company-assets.assign-assets', get_defined_vars());
    }

    public function getAsignAssets()
    {
        $asset = Asign_asset::with('assets', 'employee')->get();
        return $asset;
    }

    public function storeAsignAssets(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'asset_id' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $asset = new Asign_asset();
        $asset->emp_id = $request->emp_id;
        $asset->asset_id = $request->asset_id;
        $asset->save();

        return response()->json([
            'status' => 200,
            'message' => 'Asign Assets Successfully',
        ]);
    }

    public function editAsignAssets(Request $request)
    {
        $asset = Asign_asset::find($request->id);
        $emp = Employee::all();
        $assets = Asset::all();
        return response()->json([
            'asset' => $asset,
            'emp' => $emp,
            'assets' => $assets,
        ]);
    }

    public function updateAsignAssets(Request $request)
    {

        $asset = Asign_asset::find($request->asset_asign_id);
        $asset->emp_id = $request->emp_id;
        $asset->asset_id = $request->asset_id;
        $asset->update();

        return response()->json([
            'status' => 200,
            'message' => 'Asign Assets updated Successfully',
        ]);
    }

    public function deleteAsignAssets(Request $request)
    {
        $asset = Asign_asset::find($request->id);
        if ($asset->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Asset Deleted Successfully',
            ]);
        }
    }

    public function createSpecification()
    {
        $assets = Asset::all();
        $specs = Create_specification::all();
        return view('company-assets.create-specification', get_defined_vars());
    }

    public function storeSpecification(Request $request)
    {
        if ($request->specification != NULL) {
            $size = count($request->specification);
            for ($i = 0; $i < $size; $i++) {
                $spec = new Create_specification();
                $spec->asset_id = $request->asset_id;
                $spec->specification = $request->specification[$i];
                $spec->save();
            }
            return back()->with('success', 'Specification Added Successfully');
        }
    }

    public function editSpecification(Request $request)
    {
        $spec = Create_specification::find($request->id);
        $asset = Asset::all();
        return response()->json([
            'spec' => $spec,
            'asset' => $asset,
        ]);
    }

    public function updateSpecification(Request $request)
    {
        $spec = Create_specification::find($request->specification_id);
        $spec->asset_id = $request->asset_id;
        $spec->specification = $request->specification;
        $spec->update();

        return back()->with('success', 'Specification update Successfully');
    }

    public function deleteSpecification(Request $request)
    {
        $spec = Create_specification::find($request->id);
        if ($spec->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Specification Deleted Successfully',
            ]);
        }
    }

    public function addSpecification()
    {
        $specs = Asset::all();
        return view('company-assets.add-specification', get_defined_vars());
    }

    public function getSpecificationBaseAsset(Request $request)
    {
        return Create_specification::where('asset_id', $request->asset_id)->get();
    }

    public function storeAddSpecification(Request $request)
    {
        if ($request->specification_id != NULL) {

            $size = count($request->specification_id);

            $data = $request->all();
            $rules = array(
                'asset_id' => 'required',
                'model' => 'required',
                'price' => 'required',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $specificaton = new Specification();
            $specificaton->asset_id = $request->asset_id;
            $specificaton->model = $request->model;
            $specificaton->price = $request->price;
            $specificaton->save();

            for ($i = 0; $i < $size; $i++) {
                $spval = new Specification_value();
                $spval->asset_id = $specificaton->asset_id;
                $spval->specification_id = $specificaton->id;
                $spval->value = $request->value[$i];
                $spval->save();
            }
            return back()->with('success', 'Add Specification Value Successfully');
        } else {
            $specificaton = new Specification();
            $specificaton->asset_id = $request->asset_id;
            $specificaton->model = $request->model;
            $specificaton->price = $request->price;
            $specificaton->save();
            return back()->with('success', 'Add Specification Value Successfully');
        }
    }

    public function Specification(Request $request,$id)
    {
        $specs = Asset::find($id);
        $speval1 = Specification_value::where('asset_id',$specs->id)->first();
        $speval = Specification_value::where('asset_id',$specs->id)->get();
        $cs = Create_specification::where('asset_id',$specs->id)->get();
    
        return view('company-assets.specification', get_defined_vars());
    }
}
