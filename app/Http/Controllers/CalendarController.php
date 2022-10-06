<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{



    public function index(Request $request)
    {
    	if($request->ajax())
{

    		$data = Calendar::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get();

            return response()->json($data);
    	}

    	return view('calendar.index');
    }

    public function action(Request $request)
    {
    	if($request->ajax())
    	{
    		if($request->type == 'add')
    		{
                  $date=Carbon::now();
if($request->title=='' || $request->puriety=='' || $request->des=='')
{
    return response()->json(['errors' => 'herllo']);

}
else{
    			$event = Calendar::create([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end,
					'decription'=>	$request->des,
					'puriety' =>	$request->puriety

    			]);

                return response()->json(['success' => 'herllo']);
            }
    		}

    		if($request->type == 'update')
    		{
    			$event = Calendar::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end,

    			]);

    			return response()->json($event);
    		}

    		if($request->type == 'latest_update')
    		{
				$event = Calendar::find($request->id)->update([
					'title'		=>	$request->title,
					'decription'=>	$request->des,
					'puriety' =>	$request->purety


    			]);
				// $event = Calendar::find($request->id)->delete();

    			return response()->json($event);
    		}
    	}
    }

}
