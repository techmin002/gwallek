<?php

namespace Modules\Advisor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Advisor\Database\Factories\AdvisorFactory;

class Advisor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'designation',
        'experience',
        'projects',
        'linkedin',
        'mail',
        'facebook',
        'quote',
        'image',
        'status',
    ];

    // protected static function newFactory(): AdvisorFactory
    // {
    //     // return AdvisorFactory::new();
    // }
}
