<?php

namespace Modules\Mechanical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\Mechanical\Database\Factories\MechanicalFactory;

class Mechanical extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'branch_id',
        'purchase_date',
        'amount',
        'insurance_date',
        'insurance_document',
        'engine_number',
        'chasis_number',
        'vehicle_number',
        'service_date',
        'description',
        'status',
    ];

    // ✅ Relation with Category
    public function category()
    {
        return $this->belongsTo(MechanicalCategory::class, 'category_id');
    }

    // ✅ Relation with Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    

    // protected static function newFactory(): MechanicalFactory
    // {
    //     // return MechanicalFactory::new();
    // }
}
