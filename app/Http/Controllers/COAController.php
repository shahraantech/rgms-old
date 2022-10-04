<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use App\Models\AccountType;
use App\Models\CoaMapping;
use App\Models\DetailAcType;
use App\Models\Level_1;
use App\Models\Level_2;
use App\Models\Level_3;
use App\Models\Level_4;
use App\Models\Level_5;
use App\Models\SubAcType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class COAController extends Controller
{
    //index
    public function index(Request $request)
    {

        $level_1 = Level_1::all();
        $level_2 = Level_2::all();
        $level_3 = Level_3::all();
        $level_4 = Level_4::all();
        return view('accounts.coa.index', compact('level_1', 'level_2', 'level_3', 'level_4'));
    }

    //coaMapping
    public function coaMapping(Request $request)
    {
        if($request->isMethod('post')){
             $request->all();
             $data=Level_1::chekCoaLevel($request);
        if(CoaMapping::where('module',$request->module)->first()){
        return response()->json(['errors' => 'This module already exist'], 200);
            }
             $mapping=new CoaMapping();
            $mapping->module=$request->module;
            $mapping->head_id=$data['lHeadId'];
            $mapping->level_no=$data['coa_level'];
            $mapping->save();
            return response()->json(['success' => 'Record save successfully'], 200);
        }
         $data['mapping']=CoaMapping::getCoaMapping();
        $data['l1Head'] = Level_1::getLevel1();
        return view('accounts.coa.coa-mapping')->with(compact('data'));
    }



    //getMainAcList
    public function getMainAcList()
    {
        return $res = MainAcType::orderBy('id', 'desc')->get();
    }


    public function getSubAcList()
    {
        return $res = SubAcType::with('achead', 'achead.mainacname')->orderBy('id', 'desc')->get();
    }

    //getSubABaseOfHeadId
    public function getSubABaseOfHeadId(Request $request)
    {
        $res = SubAcType::where('ac_head_id', $request->head_id)->get();
        if ($res->count() > 0) {
            return $res;
        } else {
            return 0;
        }
    }

    //getDetailAccountBaseOfSubAcc

    public function getDetailAccountBaseOfSubAcc(Request $request)
    {
        return $res = DetailAcType::where('sub_ac_type_id', $request->sub_ac_type_id)->get();
    }

    //getDetailAcList

    public function getDetailAcList()
    {
        return $res = DetailAcType::with('subacname', 'subacname.mainacname')->orderBy('id', 'desc')->get();
    }


    public function getHeadIdBaseOfMainAccount(Request $request)
    {


        $main_ac_id = $request->main_ac_id;
        $res = AccountHead::where('main_ac_id', $main_ac_id)->get();
        return $res;
    }

    //getHeadAcList
    public function getHeadAcList()
    {
        return $res = AccountHead::with('mainacname')->orderBy('id', 'desc')->get();
    }


    public function getLevel1()
    {
        return Level_1::all();
    }

    public function storeLevel1(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'level_head' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $level_1 = new Level_1();
        $level_1->level_head = $request->input('level_head');

        $level_1->save();
        return response()->json([
            'status' => 200,
            'message' => 'Level 1 added successfully',
        ]);
    }

    public function editLevel1(Request $request)
    {
        $level_1 = Level_1::find($request->id);
        return response()->json([
            'level_1' => $level_1,
        ]);
    }

    public function updateLevel1(Request $request)
    {
        $level_1 = Level_1::find($request->level_1_id);
        $level_1->level_head = $request->input('level_head');

        $level_1->update();
        return response()->json([
            'status' => 200,
            'message' => 'Level 1 updated successfully',
        ]);
    }

    public function deleteLevel1(Request $request)
    {
        $level_1 = Level_1::find($request->id);
        if ($level_1->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Level 1 deleted successfully'
            ]);
        }
    }

    // function Level Two
    public function getLevelTwo()
    {
        $level_2 = Level_2::with('levelone')->get();
        return $level_2;
    }

    public function storeLevelTwo(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'level_one_id' => 'required',
            'level_two_head' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $level_1 = new Level_2();
        $level_1->level_one_id = $request->input('level_one_id');
        $level_1->level_two_head = $request->input('level_two_head');

        $level_1->save();
        return response()->json([
            'status' => 200,
            'message' => 'Level 2 added successfully',
        ]);
    }

    public function editLevelTwo(Request $request)
    {
        $level_2 = Level_2::find($request->id);
        $level_1 = Level_1::all();
        return response()->json([
            'level_2' => $level_2,
            'level_1' => $level_1,
        ]);
    }

    public function updateLevelTwo(Request $request)
    {

        $level_2 = Level_2::find($request->level_2_id);
        $level_2->level_one_id = $request->input('level_one_id');
        $level_2->level_two_head = $request->input('level_two_head');

        $level_2->update();
        return response()->json([
            'status' => 200,
            'message' => 'Level 2 updated successfully',
        ]);
    }

    public function deleteLevelTwo(Request $request)
    {
        $level_2 = Level_2::find($request->id);
        if ($level_2->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Level 2 deleted successfully'
            ]);
        }
    }

    public function LevelTwoBaseLevelOne(Request $request)
    {
        $main_id = Level_2::where('level_one_id', $request->level_one_id)->get();
        return $main_id;
    }

    // function level 3
    public function getLevelThree()
    {
        $level_3 = Level_3::with('leveltwo')->get();
        return $level_3;
    }

    public function storeLevelThree(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'level_two_id' => 'required',
            'level_three_head' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $level_3 = new Level_3();
        $level_3->level_two_id = $request->input('level_two_id');
        $level_3->level_three_head = $request->input('level_three_head');

        $level_3->save();
        return response()->json([
            'status' => 200,
            'message' => 'Level 3 added successfully',
        ]);
    }

    public function editLevelThree(Request $request)
    {
        $level_3 = Level_3::find($request->id);
        $level_2 = Level_2::all();
        return response()->json([
            'level_3' => $level_3,
            'level_2' => $level_2,
        ]);
    }

    public function updateLevelThree(Request $request)
    {
        $level_3 = Level_3::find($request->level_3_id);
        $level_3->level_two_id = $request->input('level_two_id');
        $level_3->level_three_head = $request->input('level_three_head');

        $level_3->update();
        return response()->json([
            'status' => 200,
            'message' => 'Level 3 updated successfully',
        ]);
    }

    public function deleteLevelThree(Request $request)
    {
        $level_3 = Level_3::find($request->id);
        if ($level_3->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Level 3 deleted successfully'
            ]);
        }
    }

    public function getLevelFour()
    {
        $level_4 = Level_4::with('levelthree')->get();
        return $level_4;
    }

    public function LevelThreeBaseLevelTwo(Request $request)
    {
        $data = Level_3::where('level_two_id', $request->level_two_id)->get();
        return $data;
    }

    public function storeLevelFour(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'level_three_id' => 'required',
            'level_four_head' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $level_4 = new Level_4();
        $level_4->level_three_id = $request->input('level_three_id');
        $level_4->level_four_head = $request->input('level_four_head');

        $level_4->save();
        return response()->json([
            'status' => 200,
            'message' => 'Level 4 added successfully',
        ]);
    }

    public function editLevelFour(Request $request)
    {
        $level_4 = Level_4::find($request->id);
        $level_3 = Level_3::all();
        return response()->json([
            'level_3' => $level_3,
            'level_4' => $level_4,
        ]);
    }

    public function updateLevelFour(Request $request)
    {
        $level_4 = Level_4::find($request->level_4_id);
        $level_4->level_three_id = $request->input('level_three_id');
        $level_4->level_four_head = $request->input('level_four_head');

        $level_4->update();
        return response()->json([
            'status' => 200,
            'message' => 'Level 4 updated successfully',
        ]);
    }

    public function deleteLevelFour(Request $request)
    {
        $level_4 = Level_4::find($request->id);
        if ($level_4->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Level 4 deleted successfully'
            ]);
        }
    }

    public function getLevelFive()
    {
        $level_5 = Level_5::with('levelfour')->get();
        return $level_5;
    }

    public function LevelFourBaseLevelThree(Request $request)
    {
        $data = Level_4::where('level_three_id', $request->level_three_id)->get();
        return $data;
    }

    public function storeLevelFive(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'level_four_id' => 'required',
            'level_five_head' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $level_5 = new Level_5();
        $level_5->level_four_id = $request->input('level_four_id');
        $level_5->level_five_head = $request->input('level_five_head');

        $level_5->save();
        return response()->json([
            'status' => 200,
            'message' => 'Level 5 added successfully',
        ]);
    }

    public function editLevelFive(Request $request)
    {
        $level_5 = Level_5::find($request->id);
        $level_4 = Level_4::all();
        return response()->json([
            'level_4' => $level_4,
            'level_5' => $level_5,
        ]);
    }

    public function updateLevelFive(Request $request)
    {
        $level_5 = Level_5::find($request->level_5_id);
        $level_5->level_four_id = $request->input('level_four_id');
        $level_5->level_five_head = $request->input('level_five_head');

        $level_5->update();
        return response()->json([
            'status' => 200,
            'message' => 'Level 5 updated successfully',
        ]);
    }

    public function deleteLevelFive(Request $request)
    {
        $level_5 = Level_5::find($request->id);
        if ($level_5->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Level 5 deleted successfully'
            ]);
        }
    }

    //getL2headsWithParams

    public function getL2headsWithParams(Request $request)
    {
        return $res = Level_2::getL2HeadsWithParams($request);
        echo json_encode($res);
    }

    public function getL3headsWithParams(Request $request)
    {
        return $res = Level_3::getL3HeadsWithParams($request);
    }

    //getL4headsWithParams
    public function getL4headsWithParams(Request $request)
    {
        return $res = Level_4::getL4HeadsWithParams($request);
    }

    //getL5headsWithParams
    public function getL5headsWithParams(Request $request)
    {
        return $res = Level_5::getL5HeadsWithParams($request);
    }


    public function getCoaLevelBalance(Request $request)
    {
        $level = 5;//$request->level;
        $coaHeadId = 6;//$request->coaHead;
        $l1 = Level_1::find($coaHeadId);
        $balance = 0;
        if ($l1) {
            $balance = $balance + $l1->balance;
            $l2 = Level_2::where('level_one_id', $l1->id)->get();
            if ($l2) {
                foreach ($l2 as $l2) {
                    $l3 = Level_3::where('level_two_id', $l2->id)->get();
                    if ($l3) {
                        foreach ($l3 as $l3) {
                            $l4 = Level_4::where('level_three_id', $l3->id)->get();
                            if ($l4) {
                                foreach ($l4 as $l4) {
                                    $l5 = Level_5::where('level_four_id', $l3->id)->get();
                                    if ($l5) {
                                        foreach ($l5 as $l5) {
                                            $balance = $l5->balance;
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }
            return $balance;

        }
    }
}
