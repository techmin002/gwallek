<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\ProjectManager\Models\Site;

// use Modules\OrderManager\Database\Factories\ReturnOrderFactory;

class ReturnOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'site_id',
        'branch_id',
        'remarks',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
    public function project()
    {
        return $this->belongsTo(Site::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function products()
    {
        return $this->hasMany(ReturnOrderProduct::class);
    }

    // protected static function newFactory(): ReturnOrderFactory
    // {
    //     // return ReturnOrderFactory::new();
    // }
}
