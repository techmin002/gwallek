<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\Finance\Database\Factories\CashDepositFactory;

class CashDeposit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'amount',
        'branch_id',
        'bank_id',
        'date',
        'image',
    ];

    // protected static function newFactory(): CashDepositFactory
    // {
    //     // return CashDepositFactory::new();
    // }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
