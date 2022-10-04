<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y ',
    ];

      public function getAcTypeAttribute($value)
    {
        return strtoupper($value);

    }

    public function headname()
    {
        return $this->belongsTo(AccountHead::class, 'exp_head_id', 'id')
            ->select(['id', 'ac_head']);
    }


    public function acname()
    {
        return $this->belongsTo(Account::class, 'ac_id', 'id');
           // ->select(['id','ac_holder_name']);
    }

    public static function updateTransaction($trans_id,$request)
    {
        $trans=Transaction::find($trans_id);
        ($request->trans_mode)?$trans->mode=$request->trans_mode:'';
        ($request->via)?$trans->against=$request->against:'';
        $trans->amount=$request->payment_amount;
        $trans->desc=$request->desc;
        $trans->save();
    }


    public static function getExpenseTransaction($fromDate,$toDate)
    {
        $qry = Transaction::query();
        $qry =$qry->join('ledgers','transactions.id','ledgers.transaction_id');
        $qry =$qry->where('transactions.trans_type','=','expense');
        $qry=$qry->where('transactions.auth_id',Auth::id());
        $qry=$qry->where('ledgers.ac_type','company-head');
        $qry=$qry->whereDate('transactions.date', '>=', $fromDate);
        $qry=$qry->whereDate('transactions.date', '<=', $toDate);
        $qry=$qry->orderBy('transactions.id','DESC');
        $qry=$qry->select('ledgers.amount','transactions.desc','transactions.date','ledgers.coa_level','coa_head_id','transactions.id');
        return $qry->get();
    }
}
