<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSummary extends Model
{
    use HasFactory;



    public function branchname()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id', 'id');
    }
}
