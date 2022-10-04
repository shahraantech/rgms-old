<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public static function getRegNoDigits($reg_no){
        $digits = preg_replace('/[^0-9]/', '', $reg_no);
        if(empty($digits)){
            $digits=1;
        }
        return $digits;
    }
    public static function getAlphaBetOfRegNo($reg_no){
       return $res= trim($reg_no, " 1..9");
    }

    public static function getStock($inv_type=NULL){
        $qry= Purchase::Query();
        $qry=$qry->with('products');
        ($inv_type==1)?$qry=$qry->where('v_group', 1):'';
        ($inv_type==2)?$qry=$qry->where('v_group', 2):'';
        $qry=$qry->where('purchases.avl_qty','>',0);
        $stock=$qry->get();
        return $stock;
    }


    public static function getStockForBulkSale($inv_type=NULL){

        $qry = Product::query();
        $qry=$qry->join('purchases', 'purchases.item_id', '=', 'products.id');
        $qry=$qry->where('purchases.avl_qty', '>',0);
        ($inv_type==1)?$qry=$qry->where('purchases.v_group', 1):'';
        ($inv_type==2)?$qry=$qry->where('purchases.v_group', 2):'';
        $qry=$qry->select('products.id','products.item');
        $qry=$qry->groupBy('purchases.item_id');
        return $stock=$qry->get();
    }


    public static function getProductPriceAndInfo($purchases_id){
        $stock= Purchase::with('products')->where('id',$purchases_id)->first();
        return $stock;
    }

    public function products()
    {
        return $this->belongsTo(Product::class,  'item_id','id');
    }
}
