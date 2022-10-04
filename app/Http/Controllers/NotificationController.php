<?php

namespace App\Http\Controllers;

use App\Models\ChFavorite;
use App\Models\ChMessage;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    protected $userId;
    public function __construct() {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }
    //countNotification
    public function countNotification(){

        $data['notification'] = collect([]);

         $data['noti']=Notification::with('sendername')
              ->where('is_read',0)
              ->where('receiver_id',$this->userId)
             ->orderByDesc('id')
              ->get();
         if($data['noti']){
             foreach($data['noti'] as $row){

                 $array = array(
                     'name' => $row->sendername['name'],
                     'image' => $row->sendername['image'],
                     'path' => $row->path,
                     'message' => $row->message,
                     'time' => $row->created_at->diffForHumans(),

                 );
                 $data['notification']->push($array);

             }
         }

         return $data;

    }

    //countMessage

    public function countMessage(){

        $data['message'] = collect([]);

        $data['countMessage']=ChMessage::with('sendername')
            ->where('to_id',Auth::user()->id)
            ->where('seen',0)
            ->get();

        if($data['countMessage']){
            foreach($data['countMessage'] as $row){

                $array = array(
                    'name' => $row->sendername['name'],
                    'image' => $row->sendername['image'],
                    'message' => $row->body,
                    'time' => $row->created_at->diffForHumans(),

                );
                $data['message']->push($array);

            }
        }

        return $data;

    }
}
