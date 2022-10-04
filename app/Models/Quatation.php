<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quatation extends Model
{
    use HasFactory;

    protected $fillable = ['vemail'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id','id')->withDefault();
    }
}
