<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function proj()
    {
        return $this->hasMany(Project::class, 'project','id');
    }

    public static function getClients()
    {
        $res=Client::orderBy('id','DESC')->get();
        return $res;
    }


    public static function getDealersAsClients()
    {
        $res=Client::where('customer_group',2)->orderBy('id','DESC')->get();
        return $res;
    }

    //saveClients
    public static function saveClients($request)
    {
        if($client=Client::where('contact',$request->$request)->first()){
        return $client->id;
        }

        $client = new Client();
        $client->name = $request->customer_name;
        $client->contact = $request->customer_contact;
        $client->city = $request->customer_city;
        $client->customer_group =2;
        $client->open_bal = 0;
        $client->lead_id =($request->customer_source==1)?$request->lead_id:'';
        if ($client->save()) {
        return $client->id;
        }
    }


}
