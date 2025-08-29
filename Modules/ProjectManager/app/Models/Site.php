<?php

namespace Modules\ProjectManager\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\ProjectManager\Database\Factories\SiteFactory;

class Site extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'amount',
        'start_date',
        'end_date',
        'image',
        'contract_image',
        'description',
        'branch_id',
        'assign_to',
        'customer_id',
        'status'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function assignments()
    {
        return $this->hasMany(ProjectAssignment::class, 'site_id');
    }
    // protected static function newFactory(): SiteFactory
    // {
    //     // return SiteFactory::new();
    // }
}
