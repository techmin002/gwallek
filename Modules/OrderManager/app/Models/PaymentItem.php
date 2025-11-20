<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model {
    protected $fillable = [
        'payment_id',
        'purchase_item_id',
        'paid_amount',
        'previous_paid',
        'new_paid_amount',
        'remaining_amount',
        'payment_status'
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'previous_paid' => 'decimal:2',
        'new_paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function purchaseItem() {
        return $this->belongsTo(PurchaseItem::class);
    }
}