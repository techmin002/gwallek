<?php

namespace Modules\ProjectManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ProjectManager\Database\Factories\SitePaymentDetailsFactory;

class SitePaymentDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'site_id',
        'payment_id',
        'payment_method',
        'amount',
        'online_image',
        'check_number',
        'date',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function payment()
    {
        return $this->belongsTo(SitePayment::class);
    }

    // protected static function newFactory(): SitePaymentDetailsFactory
    // {
    //     // return SitePaymentDetailsFactory::new();
    // }
}
