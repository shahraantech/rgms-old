<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];

    public function getStatusAttribute($value)
    {
        return strtoupper($value);
    }

    public function headname()
    {
        return $this->belongsTo(ExpenseHead::class, 'exp_head_id', 'id');
    }
}
