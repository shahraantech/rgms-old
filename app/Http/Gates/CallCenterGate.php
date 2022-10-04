<?php
namespace App\Http\Gates;

class CallCenterGate{
    public function callcenterGate($user){

          if($user->role ==='call-center' OR $user->role ==='employee' OR $user->role ==='super-admin'){
                return true;
            }else{
                return false;
            }
    }
}
?>
