<?php

namespace Modules\ProjectManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ProjectManager\Database\Factories\SitePaymentFactory;

class SitePayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'site_id',
        'amount',
        'paid_amount',
        'due_amount',
        'payment_method',
        'check_number',
        'online_image',
    ];


    public function site()
    {
        return $this->belongsTo(Site::class);
    }
      public function details()
    {
        return $this->hasMany(SitePaymentDetails::class, 'payment_id');
    }

    // protected static function newFactory(): SitePaymentFactory
    // {
    //     // return SitePaymentFactory::new();
    // }
}
