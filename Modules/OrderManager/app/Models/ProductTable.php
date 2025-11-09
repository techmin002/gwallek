<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\OrderManager\Database\Factories\ProductTableFactory;

class ProductTable extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image',
        'title',
        'price',
    ];

    // protected static function newFactory(): ProductTableFactory
    // {
    //     // return ProductTableFactory::new();
    // }
}
