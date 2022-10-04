<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\SocialPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class PlatformController extends Controller
{

    public function index(Request $request)
    {

        return view('call-center.platforms.index');
    }

    public function platformsList()
    {
        return SocialPlatform::all();
    }

    public function PlatformsStore(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'platform' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $platform = new SocialPlatform();
        $platform->platform = $request->platform;

        $platform->save();
        return response()->json([
            'status' => 200,
            'message' => 'Plateform Added successfully',
        ]);
    }

    public function platformsEdit(Request $request)
    {
        $plateform = SocialPlatform::find($request->id);
        return response()->json([
            'plateform' => $plateform,
        ]);
    }

    public function platformsUpdate(Request $request)
    {
        $plateform = SocialPlatform::find($request->plat_id);
        $plateform->platform = $request->platform;

        $plateform->update();
        return response()->json([
            'status' => 200,
            'message' => 'Plateform updated successfully',
        ]);
    }

    public function platformsDelete(Request $request)
    {
        $plateform = SocialPlatform::find($request->id);

        $plateform->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Plateform deleted successfully',
        ]);
    }
}
