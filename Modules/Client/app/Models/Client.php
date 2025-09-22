<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Client\Database\Factories\ClientFactory;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'branch_id',
        'created_by',
        'introduction',
        'image',
        'status',
    ];


    // protected static function newFactory(): ClientFactory
    // {
    //     // return ClientFactory::new();
    // }
}
