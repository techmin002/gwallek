<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\Factories\CategoriesFactory;

class Categories extends Model
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
    // protected static function newFactory(): CategoriesFactory
    // {
    //     // return CategoriesFactory::new();
    // }
}
