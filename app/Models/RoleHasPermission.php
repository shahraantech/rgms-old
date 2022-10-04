<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;

    public function permissionname()
    {
        return $this->belongsTo(SubModule::class, 'permission_id', 'id');
    }


    public function rolename()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:d M Y',
    ];
}
