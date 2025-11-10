<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;

class Inventory extends Model
{
    protected $fillable = [
        'product_id', 'branch_id', 'quantity', 'opening_quantity', 'updated_by', 'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function DevicePurchaseAccessory()
    {
        return $this->belongsToMany(Accessories::class, 'device_purchase_accessories', 'inventory_id', 'accessory_id')
            ->withPivot('quantity', 'price', 'total', 'branch_id')
            ->withTimestamps();
    }
    public function DevicePurchaseMachinery()
    {
        return $this->belongsToMany(Machineries::class, 'device_purchase_machineries', 'inventory_id', 'machinery_id')
            ->withPivot('quantity', 'price', 'total', 'branch_id')
            ->withTimestamps();
    }
}
