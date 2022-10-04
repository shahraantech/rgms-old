<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_1 extends Model
{
    use HasFactory;


protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
];

public static function getLevel1(){
    return $res=Level_1::select('id','level_head')->get();
}


    public static function getLevel4(){
        return $res=Level_4::select('id','level_four_head as level_head')->get();
    }

    public static function chekCoaLevel($request){

        if($request->l1headId){
            $data['coa_level']=1;
            $data['lHeadId']=$request->l1headId;
        }
        if($request->l2headId){
            $data['coa_level']=2;
            $data['lHeadId']=$request->l2headId;
        }
        if($request->l3headId){
            $data['coa_level']=3;
            $data['lHeadId']=$request->l3headId;
        }
        if($request->l4headId){
            $data['coa_level']=4;
            $data['lHeadId']=$request->l4headId;
        }
        if($request->l5headId){
            $data['coa_level']=5;
            $data['lHeadId']=$request->l5headId;
        }
        return $data;
    }


    public static function getLevelBalance($head_id,$level){
    $l1Balance=0;
    $l2Balance=0;
    $l3Balance=0;
    $l4Balance=0;
    $l5Balance=0;

    if($level==1) {

        $l1=Level_1::where('id',$head_id)->get();
        foreach ($l1 as $l1){
            $l2=Level_2::where('level_one_id',$l1->id)->get();
            if($l2->count() > 0) {
                foreach ($l2 as $l2) {
                    $l3 = Level_3::where('level_two_id', $l2->id)->get();
                    if($l3->count() > 0){

                        foreach ($l3 as $l3){
                            $l4 = Level_4::where('level_three_id', $l3->id)->get();
                            if($l4->count() > 0){
                                foreach ($l4 as $l4){
                                    $l5 = Level_5::where('level_four_id', $l4->id)->get();
                                    if($l5->count() > 0){
                                        foreach($l5 as $l5) {
                                            $getl5Balance=self::countLevelWiseBalance('5',$l5->id);
                                            $l5Balance=$l5Balance+$getl5Balance;
                                        }
                                    }else{
                                        $getL4Balance=self::countLevelWiseBalance('4',$l4->id);
                                        $l4Balance=$l4Balance+$getL4Balance;

                                    }
                                }
                            }else{
                                $getL3Balance=self::countLevelWiseBalance('3',$l3->id);
                                $l3Balance=$l3Balance+$getL3Balance;
                            }
                        }
                    }else{
                        $getL2Balance=self::countLevelWiseBalance('2',$l2->id);
                        $l2Balance=$l2Balance+$getL2Balance;
                    }
                }
            }
            else{
                $getL1Balance=self::countLevelWiseBalance('1',$head_id);
                $l1Balance=$l1Balance+$getL1Balance;
                $l1Balance;
            }
        }

        $totalL5Balance=$l1Balance + $l2Balance + $l3Balance + $l4Balance + $l5Balance;
        return  $totalL5Balance;
}
    if($level==2) {
                $l2 = Level_2::where('id',$head_id)->get();
                if ($l2->count() > 0) {
                    foreach ($l2 as $l2) {
                        $l3 = Level_3::where('level_two_id', $l2->id)->get();
                        if ($l3->count() > 0) {

                            foreach ($l3 as $l3) {
                                $l4 = Level_4::where('level_three_id', $l3->id)->get();
                                if ($l4->count() > 0) {
                                    foreach ($l4 as $l4) {
                                        $l5 = Level_5::where('level_four_id', $l4->id)->get();
                                        if ($l5->count() > 0) {
                                            foreach ($l5 as $l5) {
                                                $getl5Balance = self::countLevelWiseBalance('5', $l5->id);
                                                $l5Balance = $l5Balance + $getl5Balance;
                                            }
                                        } else {
                                            $getL4Balance = self::countLevelWiseBalance('4', $l4->id);
                                            $l4Balance = $l4Balance + $getL4Balance;

                                        }
                                    }
                                } else {
                                    $getL3Balance = self::countLevelWiseBalance('3', $l3->id);
                                    $l3Balance = $l3Balance + $getL3Balance;
                                }
                            }
                        } else {
                            $getL2Balance = self::countLevelWiseBalance('2', $l2->id);
                            $l2Balance = $l2Balance + $getL2Balance;
                        }
                    }
                } else {
                    $getL1Balance = self::countLevelWiseBalance('2', $head_id);
                    $l1Balance = $l1Balance + $getL1Balance;
                    $l1Balance;
                }

            $totalL5Balance = $l1Balance + $l2Balance + $l3Balance + $l4Balance + $l5Balance;
            return $totalL5Balance;
        }

                    //get Balance for level3
                    if($level==3) {
                    $l3 = Level_3::where('id', $head_id)->get();
                    if ($l3->count() > 0) {
                        foreach ($l3 as $l3) {
                            $l4 = Level_4::where('level_three_id', $l3->id)->get();
                            if ($l4->count() > 0) {
                                foreach ($l4 as $l4) {
                                    $l5 = Level_5::where('level_four_id', $l4->id)->get();
                                    if ($l5->count() > 0) {
                                        foreach ($l5 as $l5) {
                                            $getl5Balance = self::countLevelWiseBalance('5', $l5->id);
                                            $l5Balance = $l5Balance + $getl5Balance;
                                        }
                                    } else {
                                        $getL4Balance = self::countLevelWiseBalance('4', $l4->id);
                                        $l4Balance = $l4Balance + $getL4Balance;

                                    }
                                }
                            } else {
                                $getL3Balance = self::countLevelWiseBalance('3', $l3->id);
                                $l3Balance = $l3Balance + $getL3Balance;
                            }
                        }
                    }
                    else {
                        $getL2Balance = self::countLevelWiseBalance('3',$head_id);
                        $l2Balance = $l2Balance + $getL2Balance;
                    }

            $totalL5Balance = $l1Balance + $l2Balance + $l3Balance + $l4Balance + $l5Balance;
            return $totalL5Balance;
        }


        //get Balance for level4
        if($level==4) {

                    $l4 = Level_4::where('id', $head_id)->get();
                    if ($l4->count() > 0) {
                        foreach ($l4 as $l4) {
                            $l5 = Level_5::where('level_four_id', $l4->id)->get();
                            if ($l5->count() > 0) {
                                foreach ($l5 as $l5) {
                                    $getl5Balance = self::countLevelWiseBalance('5', $l5->id);
                                    $l5Balance = $l5Balance + $getl5Balance;
                                }
                            } else {
                                $getL4Balance = self::countLevelWiseBalance('4', $l4->id);
                                $l4Balance = $l4Balance + $getL4Balance;

                            }
                        }
                    }
                    else {
                        $getL3Balance = self::countLevelWiseBalance('3', $head_id);
                        $l3Balance = $l3Balance + $getL3Balance;
                    }

            $totalL5Balance = $l1Balance + $l2Balance + $l3Balance + $l4Balance + $l5Balance;
            return $totalL5Balance;
        }


        //get Balance for level5
        if($level==5) {
                    $l5 = Level_5::where('id', $head_id)->get();
                    if ($l5->count() > 0) {
                        foreach ($l5 as $l5) {
                            $getl5Balance = self::countLevelWiseBalance('5', $l5->id);
                            $l5Balance = $l5Balance + $getl5Balance;
                        }
                    } else {
                        $getL4Balance = self::countLevelWiseBalance('5',$head_id);
                        $l4Balance = $l4Balance + $getL4Balance;
                    }

            $totalL5Balance = $l1Balance + $l2Balance + $l3Balance + $l4Balance + $l5Balance;
            return $totalL5Balance;
        }

    }

    public static function countLevelWiseBalance($level_no,$coa_head_id){

        $balance=0;
        $crSum = Ledger::where('coa_level', $level_no)->where('coa_head_id', $coa_head_id)->where('ledger_type', 'cr')->sum('amount');
        $drSum = Ledger::where('coa_level', $level_no)->where('coa_head_id', $coa_head_id)->where('ledger_type', 'dr')->sum('amount');
        $balance = $drSum - $crSum;
        return $balance;
    }

}
