<?php

namespace Modules\Mechanical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Mechanical\Database\Factories\MechanicalCategoryFactory;

class MechanicalCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MechanicalCategoryFactory
    // {
    //     // return MechanicalCategoryFactory::new();
    // }
}
