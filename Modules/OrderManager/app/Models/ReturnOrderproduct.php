<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Models\Product;

// use Modules\OrderManager\Database\Factories\ReturnOrderproductFactory;

class ReturnOrderproduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'return_order_id',
        'product_id',
        'quantity',
    ];

    public function returnOrder()
    {
        return $this->belongsTo(ReturnOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // protected static function newFactory(): ReturnOrderproductFactory
    // {
    //     // return ReturnOrderproductFactory::new();
    // }
}
