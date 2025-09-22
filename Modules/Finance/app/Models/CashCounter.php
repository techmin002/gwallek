<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Finance\Database\Factories\CashCounterFactory;

class CashCounter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'opening_amount',
        'reduce_amount',
        'due_amount',
    ];

    // protected static function newFactory(): CashCounterFactory
    // {
    //     // return CashCounterFactory::new();
    // }
}
