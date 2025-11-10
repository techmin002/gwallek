<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\OrderManager\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_id', 'product_name', 'quantity','status', 'unit'];

    public function items()
    {
        return $this->hasMany(ProductItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
