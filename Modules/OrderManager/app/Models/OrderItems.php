<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Models\Product;
use Modules\ProjectManager\Models\Site;

// use Modules\OrderManager\Database\Factories\OrderItemsFactory;

class OrderItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'project_id',
        'product_name',
        'quantity',
        'price',
        'image',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function project()
    {
        return $this->belongsTo(Site::class, 'project_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
   
}
