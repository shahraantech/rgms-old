<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use App\Models\BuildingCost;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Purchase;
use Google\Service\Directory\Building;
use Illuminate\Http\Request;

class BuilderController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $build = new Buildings();
            $build->title = $request->input('title');
            $build->plot_no = $request->input('plot_no');
            $build->block = $request->input('block');
            $build->size = $request->input('size');
            $build->society_name = $request->input('society_name');
            if ($build->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'buildings added successfully'
                ]);
            }
        }
        return view('accounts.builders.index');
    }

    //buildingsList
    public function buildingsList(Request $request)
    {

            if ($request->ajax() &&  $request->isMethod('get')) {

                return Buildings::all();
            }
            return view('accounts.builders.buildings-list');
        }


    public function editBuildings(Request $request)
    {
        $build = Buildings::find($request->id);
        return $build;
    }

    public function updateBuildings(Request $request)
    {
        $build = Buildings::find($request->build_id);
        $build->title = $request->input('title');
        $build->plot_no = $request->input('plot_no');
        $build->block = $request->input('block');
        $build->size = $request->input('size');
        $build->society_name = $request->input('society_name');
        if ($build->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'buildings udpated successfully'
            ]);
        }
    }

    public function deleteBuildings(Request $request)
    {
        $build = Buildings::find($request->id);
        if ($build->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'buildings deleted successfully'
            ]);
        }
    }

    //buildings-cost
    public function buildingsCost(Request $request)
    {

        if ($request->isMethod('post')) {
            $input = $request->all();
            $building_id = $request->building_id;

            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {

                    //update stock

                    updateStock($input['item_id'][$c], $input['qty'][$c], $action = 0);

                    $build = new BuildingCost();
                    $build->building_id = $request->building_id;
                    $build->item_id = $input['item_id'][$c];
                    $build->price = $input['price'][$c];
                    $build->qty = $input['qty'][$c];
                    $build->save();
                    updateStock($input['item_id'][$c], $input['qty'][$c], $action = 0);

                    $build = new BuildingCost();
                    $build->building_id = $request->building_id;
                    $build->item_id = $input['item_id'][$c];
                    $build->price = $input['price'][$c];
                    $build->qty = $input['qty'][$c];
                    $build->save();
                }
            }
        }
        $data['items'] = Purchase::join('products', 'purchases.item_id', 'products.id')
            ->join('categories', 'categories.id', 'products.cat_id')
            ->where('categories.id', 1)
            ->where('purchases.avl_qty', '>', 0)
            ->get();
        return view('accounts.builders.buildings-cost')->with(compact('data'));
    }

    //getBuildings
    public function getBuildings()
    {
        return Buildings::all();
    }

    //buildingsCostDetail

    public function buildingsCostDetail(Request $request)
    {

        $data['buildingCost'] =  BuildingCost::join('products', 'products.id', 'building_costs.item_id')
            ->where('building_costs.building_id', $request->building_id)
            ->select('products.item', 'building_costs.*')
            ->get();
        return view('accounts.builders.building-cost-detail')->with(compact('data'));
    }
}
