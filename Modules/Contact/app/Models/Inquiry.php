<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Contact\Database\Factories\InquiryFactory;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'project_type',
        'description',
        'status',
    ];

    // protected static function newFactory(): InquiryFactory
    // {
    //     // return InquiryFactory::new();
    // }
}
