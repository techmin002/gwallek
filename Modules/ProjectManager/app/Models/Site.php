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
        'status',
        'location',
        'progress_status',
        'project_area',
        'contract_id',
        'overview',
        'key_features',
        'technical_specifications',
        'environmental_impact',
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

    public function images()
    {
        return $this->hasMany(SiteImages::class);
    }
    // protected static function newFactory(): SiteFactory
    // {
    //     // return SiteFactory::new();
    // }
    public function relatedProjects()
    {
        return $this->hasMany(RelatedProject::class, 'site_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(SitePayment::class);
    }
    public function paymentDetails()
    {
        return $this->hasMany(SitePaymentDetails::class, 'site_id');
    }

    public function orders()
    {
        return $this->hasMany(\Modules\OrderManager\Models\Order::class, 'project_id');
    }
}
