<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];

    public function employee()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }

    //saveCompany
    public static function saveCompany($request)
    {
        $com=new Company();
        $com->name=$request->company_name;
        $com->working_days=26;
        $com->allow_holidays=1;
        $com->lat=$request->lat;
        $com->lang=$request->long;
        $com->address=$request->address;
        $com->save();
       return $com;
    }

    public static function getCompanyName($company_id)
    {
        return $res = Company::where('id', $company_id)->pluck('name');
    }

    public static function getAllCompanies()
    {
        return $res = Company::all();
    }
}
