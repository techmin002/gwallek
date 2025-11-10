<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\OrderManager\Database\Factories\OrderHistoryFactory;

class OrderHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'status',
        'message',
        'date',
    ];
    // protected static function newFactory(): OrderHistoryFactory
    // {
    //     // return OrderHistoryFactory::new();
    // }
}
