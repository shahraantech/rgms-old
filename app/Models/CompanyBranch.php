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

    //saveCompanyBranch
    public static function saveCompanyBranch($comp_id,$request)
    {
      $branch=new CompanyBranch();
        $branch->mh=$comp_id;
        $branch->company_id=$comp_id;
        $branch->branch_name=$request->company_name;
        $branch->focal_person=$request->name;
        $branch->contact=$request->contact;
        $branch->lat=$request->lat;
        $branch->lang=$request->long;
        $branch->address=$request->address;
        $branch->save();
    }
}
