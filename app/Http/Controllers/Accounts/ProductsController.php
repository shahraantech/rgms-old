<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class ProductsController extends Controller
{
    //products
    public function index(Request $request)
    {

        if ($request->isMethod('post') ) {
            $data = $request->all();
            $rules = array(
                'item_type_id' => 'required',
                'cat_id' => 'required',
                'item_name' => 'required',
                'unit' => 'required',
                'qty_unit' => 'required',

            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $pro = new Product();
            $pro->item_type_id = $request->item_type_id;
            $pro->cat_id = $request->cat_id;
            $pro->item = $request->item_name;
            $pro->unit = $request->unit;
            $pro->qty_in_unit = $request->qty_unit;
            $pro->unit_price = 1;
            $pro->price = 1 * $request->qty_unit;
            if ($pro->save()) {
                return response()->json(['success' => 'Item save successfully'], 200);
            }
        }

        $data['categories'] = Category::all();
        return view('accounts.products.index')->with(compact('data'));
    }

    //productsList
    public function productsList(Request $request)
    {
        return view('accounts.products.products-list');
    }

    public function showProductsList()
    {
        return Product::with('getcatname')->select('products.*')->get();

    }

    //edit products
    public function editProducts(Request $request)
    {
        $pro = Product::find($request->id);
        $categ = Category::all();
        return view('accounts.products.edit-products', compact('pro', 'categ'));
    }

    //update products
    public function updateProducts(Request $request)
    {
        $pro = Product::find($request->id);
        $pro->cat_id = $request->cat_id;
        $pro->item = $request->item_name;
        $pro->unit = $request->unit;
        $pro->qty_in_unit = $request->qty_unit;
        $pro->price = $request->price;
        if ($pro->save()) {
            return redirect('products-list')->with('product udpated successfully');
        }
    }

    public function deleteProducts(Request $request)
    {
        $pro = Product::find($request->id);
        if ($pro->delete()) {
            return response()->json([
                'message' => 'product deleted successfully'
            ]);
        }
    }


    public function getProductInfo(Request $request)
    {

        if ($request->mode == 1) {
            return $res = Product::find($request->product_id);
            }
        else {
            $pur = Purchase::find($request->product_id);
            return $res = Product::find($pur->item_id);

        }
    }
}
