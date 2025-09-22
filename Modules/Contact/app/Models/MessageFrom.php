<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Contact\Database\Factories\MessageFromFactory;

class MessageFrom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'role',
        'description',
        'image',
        'signature',
    ];

    // protected static function newFactory(): MessageFromFactory
    // {
    //     // return MessageFromFactory::new();
    // }
}
