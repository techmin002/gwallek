<?php


namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Entities\DevicePurchase;
use Modules\Product\Models\Product;

// use Modules\Inventory\Database\Factories\DevicePurchaseProductFactory;

class DevicePurchaseProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'device_purchase_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
    ];

    public function purchase()
    {
        return $this->belongsTo(DevicePurchase::class, 'device_purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    // protected static function newFactory(): DevicePurchaseProductFactory
    // {
    //     // return DevicePurchaseProductFactory::new();
    // }
}
