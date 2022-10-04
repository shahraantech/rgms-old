<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\ChMessage;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //index
    public function index(){
        //$data['employees']=User::with(['empname' => fn ($query) => $query->select('id','name')])->get();
        $data['users'] = collect([]);
        $user=User::where('status',1)->get();
        foreach ($user as $row){

            $countMessage=ChMessage::where('from_id',$row->id)->where('seen',0)->count();
            $array = array(
                'id' => $row->id,
                'name' => $row->name,
                'avatar' => $row->avatar,
                'countMessage' => $countMessage,

            );
            $data['users']->push($array);
        }

        return view('call-center.chat.index')->with(compact('data'));
    }
}
