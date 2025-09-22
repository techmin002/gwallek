<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ProjectManager\Models\Site;

// use Modules\OrderManager\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Site::class, 'project_id');
    }

    public function products()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class);
    }

    // protected static function newFactory(): OrderFactory
    // {
    //     // return OrderFactory::new();
    // }
}
