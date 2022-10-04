<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {

//         $data['stock'] = Purchase::join('products','products.id','purchases.item_id')
////            ->where('products.cat_id',1)
//             ->orderBy('purchases.id','DESC')
//            ->get();
         $data['stock'] =Purchase::with('products')->get();

        return view('accounts.stock.index')->with(compact('data'));
    }


    //stockRawMaterial
    public function stockRawMaterial(Request $request)
    {

         $data['stock'] = Purchase::join('products','products.id','purchases.item_id')
            ->where('products.cat_id',2)
            ->get();
        return view('accounts.stock.stock-raw-material')->with(compact('data'));
    }
}
