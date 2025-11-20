<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\OrderManager\Models\PurchaseItem;
// use Modules\OrderManager\Database\Factories\OrderFactory;

class OrderItem extends Model {
    protected $fillable = ['order_id','product_name','quantity','unit','status'];
    public function order() { return $this->belongsTo(Order::class); }
    public function purchases() { return $this->hasMany(PurchaseItem::class); }
}

