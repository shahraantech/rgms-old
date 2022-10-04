<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallRecording;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;


class CallRecordingController extends Controller
{

    public function callRecording(Request $request)
    {


        $data = $request->all();
        $rules = array(
            'file' => 'required',
            'phone' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        if ($request->hasFile('file')) {

            $uniqueid = uniqid();
            $music_file = $request->file('file');
            $extension = $music_file->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $path = $music_file->storeAs('public/uploads/call-recordings/', $filename);


            $call = new CallRecording();
            $call->phone = $request->phone;
            $call->audio_file = $filename;
            $call->path = $path;
            if ($call->save()) {
                return response()->json(['success' => 'Recording save successfully']);
            } else {
                return response()->json(['success' => 'Recording not save ']);
            }
        }
    }
}
