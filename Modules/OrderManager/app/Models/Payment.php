<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payment extends Model {
    protected $fillable = [
        'receipt_number',
        'payment_type',
        'remark',
        'attachment',
        'total_paid_amount',
        'paid_by',
        'project_id',
        'transaction_id',
        'paid_at'
    ];
    
    public function invoice() { 
        return $this->hasOne(Invoice::class); 
    }
    
    public function paymentItems() {
        return $this->hasMany(PaymentItem::class);
    }

    public function paidBy() {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function project() {
        return $this->belongsTo(\Modules\ProjectManager\Models\Site::class, 'project_id');
    }

    public function purchaseItems() {
        return $this->hasManyThrough(
            PurchaseItem::class,
            PaymentItem::class,
            'payment_id',
            'id',
            'id',
            'purchase_item_id'
        );
    }
}