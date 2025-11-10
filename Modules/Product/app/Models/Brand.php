<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\Factories\BrandFactory;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
     protected $fillable = [
        'name',
        'image',
        'description',
        'status',
    ];
    // protected static function newFactory(): BrandFactory
    // {
    //     // return BrandFactory::new();
    // }
}
