<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    //products
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id','id')->select(['id','item','unit']);
    }

}
