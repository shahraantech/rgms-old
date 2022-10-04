<?php
namespace App\Http\Gates;

class EmployeeGate{
    public function employeeGate($user){

          if($user->role ==='employee' OR $user->role ==='call-center' OR $user->role ==='super-admin'){
                return true;
            }else{
                return false;
            }
    }
}
?>
