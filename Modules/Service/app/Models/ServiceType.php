<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Service\Database\Factories\ServiceTypeFactory;

class ServiceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_id',
        'name',
        'title',
        'overview',
        'description',
        'benifits',
        'image',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // protected static function newFactory(): ServiceTypeFactory
    // {
    //     // return ServiceTypeFactory::new();
    // }
}
