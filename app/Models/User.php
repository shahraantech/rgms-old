<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'account_id',
        'name',
        'email',
        'password',
        'role',
        'trainer_id',
        'role_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//
//    public function getRoleAttribute($value)
//    {
//        if($value==0){
//            $getVal='Deactivate';
//        }else{
//            $getVal='Active';
//        }
//        return $getVal;
//    }

//
//    public function setStatusAttribute($value)
//    {
//        if($value=='active'){
//            $setVal=1;
//        }else{
//            $setVal=0;
//        }
//        $this->attributes['status'] =$setVal;
//    }



    public function empname()
    {
        return $this->hasOne(Employee::class,'id','account_id');
    }

    //rolename
    public function rolename()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
