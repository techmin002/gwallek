<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\OrderManager\Database\Factories\ProductItemFactory;

class ProductItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'product_id',
        'image',
        'title',
        'price',
    ];

    

    
}
