<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'ac_id', 'id');
    }

    public function achead()
    {
        return $this->belongsTo(AccountHead::class, 'ac_head_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];

    public function supplier()
    {
        return $this->belongsTo(Vendor::class, 'ac_id', 'id')->select(['name', 'id']);
    }

    public static function getFileRegNo($type, $inv_id)
    {

        $data = collect([]);
        // 1 use for purchase
        if($type == 1){
            $item = Purchase::where('inv_no', $inv_id)->get();
        }else {
            $pur = Purchase::with('product')->find($invItem->purchase_id);
            $item = InvoiceItem::where('inv_no', $inv_id)->get();
        }

        foreach ($item as $item) {
            $data->push($item->reg_no);
            }
        return  $data;
    }
}


