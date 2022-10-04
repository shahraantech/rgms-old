<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Property_project;
use App\Models\Property_type;
use App\Models\Property_variation;
use App\Models\Property_variation_value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class PropertyController extends Controller
{
    public function propertyType()
    {
        return view('call-center.property.property_type.index');
    }

    public function getPropertyType()
    {
        $prop = Property_type::all();
        return $prop;
    }

    public function storePropertyType(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'type' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $prop = new Property_type();
        $prop->type = $request->type;
        if ($prop->save()) {
            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }

    public function propertyVariation(Request $request)
    {
        if ($request->isMethod('post')) {

            
            $size = count($request->variation);
            for ($i = 0; $i < $size; $i++) {

                $emp = new Property_variation();
                $emp->type_id = $request->type_id;
                $emp->variation = $request->variation[$i];
                $emp->save();
            }
            return back()->with('success', 'Property Variation Successfully');
        }

        $data['property_heads'] = Property_type::all();
        return view('call-center.property.property_variation.index', compact('data'));
    }

    public function getpropertyVariation(Request $request)
    {
        $variation = Property_variation::with('type')->get();
        return $variation;
    }

    public function Property()
    {
        return view('call-center.property.all_property.index');
    }

    public function createProperty(Request $request)
    {
        if ($request->isMethod('post')) {

            if ($request->variation_id != NULL) {

                $size = count($request->variation_id);

                $data = $request->all();
                $rules = array(
                    'property_type_id' => 'required',
                    'owner_name' => 'required',
                    'type' => 'required',
                    'location' => 'required',
                    'owner_contact' => 'required',
                );
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
                
                $pro = new Property();
                $pro->property_type_id = $request->property_type_id;
                $pro->project_id = $request->project_id;
                $pro->property_category = $request->property_category;
                $pro->owner_name = $request->owner_name;
                $pro->type = $request->type;
                $pro->property_for = $request->property_for;
                $pro->location = $request->location;
                $pro->owner_contact = $request->owner_contact;
                $pro->save();

                for ($i = 0; $i < $size; $i++) {

                    $pur = new Property_variation_value();
                    $pur->property_id = $pro->id;
                    $pur->variation_id = $request->variation_id[$i];
                    $pur->value = $request->value[$i];
                    $pur->save();
                }
                return back()->with('success', 'Property Added Successfully');
            } else {
                $pro = new Property();
                $pro->property_type_id = $request->property_type_id;
                $pro->project_id = $request->project_id;
                $pro->property_category = $request->property_category;
                $pro->owner_name = $request->owner_name;
                $pro->type = $request->type;
                $pro->property_for = $request->property_for;
                $pro->location = $request->location;
                $pro->owner_contact = $request->owner_contact;
                $pro->save();
                return back()->with('success', 'Property Added Successfully');
            }
        }

        $data['props'] = Property_type::all();
        $data['project'] = Property_project::all();
        return view('call-center.property.all_property.create-property', compact('data'));
    }

    public function getPropertyBaseVariation(Request $request)
    {
        return Property_variation::where('type_id', $request->type_id)->get();
    }

    public function getSeller(Request $request)
    {
        $qry = Property::query();
        $qry = $qry->where('type', '=', 'Seller');

        if ($request->isMethod('post')) {

            $qry->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            });

            $qry->when($request->owner_name, function ($query, $owner_name) {
                return $query->where('owner_name', 'like', '%' . $owner_name . '%');
            });

            $qry->when($request->location, function ($query, $location) {
                return $query->where('location', 'like', '%' . $location . '%');
            });

            $qry->when($request->owner_contact, function ($query, $owner_contact) {
                return $query->where('owner_contact', 'like', '%' . $owner_contact . '%');
            });

            $qry->when($request->property_type_id, function ($query, $property_type_id) {
                return $query->where('property_type_id', $property_type_id);
            });
        }

        $pageTitle = 'Seller';
        $subTitle = 'Seller List';
        $sellers = $qry->get();
        $prop_typs = Property_type::all();
        return view('call-center.property.seller.index', get_defined_vars());
    }

    public function getBuyer(Request $request)
    {
        $qry = Property::query();
        $qry = $qry->where('type', '=', 'Buyer');

        if ($request->isMethod('post')) {

            $qry->when($request->owner_name, function ($query, $owner_name) {
                return $query->where('owner_name', 'like', '%' . $owner_name . '%');
            });

            $qry->when($request->location, function ($query, $location) {
                return $query->where('location', 'like', '%' . $location . '%');
            });

            $qry->when($request->owner_contact, function ($query, $owner_contact) {
                return $query->where('owner_contact', 'like', '%' . $owner_contact . '%');
            });

            $qry->when($request->property_type_id, function ($query, $property_type_id) {
                return $query->where('property_type_id', $property_type_id);
            });

            $qry->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            });
        }

        $pageTitle = 'Buyer';
        $subTitle = 'Buyer List';
        $sellers = $qry->get();
        $prop_typs = Property_type::all();
        return view('call-center.property.seller.index', get_defined_vars());
    }

    public function sellerBuyerDetail(Request $request)
    {
        $res = Property_variation_value::with('provaration')->where('property_id', $request->property_id)->get();
        return $res;
    }

    public function statusUpdate(Request $request)
    {
        $stat = Property::where('id', $request->id)->first();
        if ($stat->status == 1) {
            $stat->status = 0;
            $stat->update();
        } else if ($stat->status == 0) {
            $stat->status = 1;
            $stat->update();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Status update successfully',
        ]);
    }

    public function propertyEdit(Request $request)
    {
        $prop = Property::find($request->id);
        $prop_type = Property_type::all();
        $proj = Property_project::all();
        return response()->json([
            'prop' => $prop,
            'proj' => $proj,
            'prop_type' => $prop_type,
        ]);
    }

    public function propertyUpdate(Request $request)
    {
        $prop = Property::find($request->property_id);
        $prop->owner_name = $request->owner_name;
        $prop->location = $request->location;
        $prop->property_type_id = $request->property_type_id;
        $prop->project_id = $request->project_id;
        $prop->property_category = $request->property_category;
        $prop->owner_contact = $request->owner_contact;
        $prop->property_for = $request->property_for;

        $prop->update();
        return response()->json([
            'status' => 200,
            'message' => 'Data updated Successfully',
        ]);
    }

    public function propertyDelete(Request $request)
    {
        $prop = Property::find($request->id);
        if ($prop->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Data deleted Successfully',
            ]);
        }
    }

    public function propertyProjects(Request $request)
    {
        return view('call-center.property.all_property.property-projects');
    }

    public function getPropertyProjects()
    {
        $prop_projects = Property_project::all();
        return $prop_projects;
    }

    public function propertyProjectsStore(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'name' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $proj = new Property_project();
        $proj->name = $request->name;
        $proj->save();
        return response()->json([
            'status' => 200,
            'message' => 'Poperty project Added Successfully',
        ]);
    }

    public function propertyProjectsEdit(Request $request)
    {
        $proj = Property_project::find($request->id);
        return response()->json([
            'proj' => $proj,
        ]);
    }

    public function propertyProjectsUpdate(Request $request)
    {
        $proj = Property_project::find($request->prop_project_id);
        $proj->name = $request->name;
        $proj->update();
        return response()->json([
            'status' => 200,
            'message' => 'Poperty project updated Successfully',
        ]);
    }

    public function propertyProjectsDelete(Request $request)
    {
        $proj = Property_project::find($request->id);
        if ($proj->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Poperty project deleted Successfully',
            ]);
        }
    }

    public function editPropertyType(Request $request)
    {
        $type = Property_type::find($request->id);
        return response()->json([
            'type' => $type,
        ]);
    }

    public function updatePropertyType(Request $request)
    {
        $type = Property_type::find($request->type_id);
        $type->type = $request->type;
        $type->update();
        return response()->json([
            'status' => 200,
            'message' => 'Poperty type updated Successfully',
        ]);
    }

    public function deletePropertyType(Request $request)
    {
        $type = Property_type::find($request->id);
        if ($type->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Poperty type deleted Successfully',
            ]);
        }
    }

    public function editPropertyVariation(Request $request)
    {
        $prop_var = Property_variation::find($request->id);
        $type = Property_type::all();
        return response()->json([
            'prop_var' => $prop_var,
            'type' => $type,
        ]);
    }

    public function updatePropertyVariation(Request $request)
    {
        $prop_var = Property_variation::find($request->variation_id);
        $prop_var->type_id = $request->type_id;
        $prop_var->variation = $request->variation;
        $prop_var->update();

        return response()->json([
            'status' => 200,
            'message' => 'Poperty varition updated Successfully',
        ]);
    }

    public function deletePropertyVariation(Request $request)
    {
        $prop_var = Property_variation::find($request->id);
        if ($prop_var->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Poperty varition deleted Successfully',
            ]);
        }
    }
}
