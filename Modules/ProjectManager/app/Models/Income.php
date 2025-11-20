<?php

namespace Modules\ProjectManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\ProjectManager\Database\Factories\CustomerFactory;

class Income extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    'site_id',
    'title',
    'amount',
    'received_date',
    'payment_method',
    'note',
    'receipt_image',
];

  protected $dates = ['received_date'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    
}
