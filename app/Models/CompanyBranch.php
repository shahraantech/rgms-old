<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y',
    ];
    //companyname

    public function companyname()
    {
        return $this->belongsTo(Company::class,  'company_id','id')->select(['id', 'name']);
    }
}
