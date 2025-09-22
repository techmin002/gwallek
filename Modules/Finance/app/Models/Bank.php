<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\Finance\Database\Factories\BankFactory;

class Bank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'bank_name',
        'bank_holder_name',
        'account_number',
        'address',
        'branch_id',
        'mobile_no',
        'opening_amount',
        'closing_amount',
        'status',
    ];

    public function deposits()
    {
        return $this->hasMany(CashDeposit::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    // protected static function newFactory(): BankFactory
    // {
    //     // return BankFactory::new();
    // }
}
