<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\Contact\Database\Factories\ContactFactory;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    // protected static function newFactory(): ContactFactory
    // {
    //     // return ContactFactory::new();
    // }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
