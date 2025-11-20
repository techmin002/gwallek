<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model {
    protected $fillable = [
        'order_item_id','purchased_qty','remaining_qty','per_unit_price','total_price',
        'image','title','purchased_by'
    ];
    
    // Add these to make accessors work properly
    protected $appends = ['paid_amount', 'remaining_amount', 'payment_status'];
    
    public function orderItem() { 
        return $this->belongsTo(OrderItem::class); 
    }
    
    // Relationship to payment_items table
    public function paymentItems() { 
        return $this->hasMany(PaymentItem::class); 
    }
    
    // Accessor for paid amount
    public function getPaidAmountAttribute()
    {
        return $this->paymentItems()->sum('paid_amount');
    }
    
    // Accessor for remaining amount
    public function getRemainingAmountAttribute()
    {
        return max(0, $this->total_price - $this->paid_amount);
    }
    
    // Accessor for payment status
    public function getPaymentStatusAttribute()
    {
        $paidAmount = $this->paid_amount;
        $totalPrice = $this->total_price;
        
        if ($paidAmount <= 0) {
            return 'unpaid';
        } elseif ($paidAmount >= $totalPrice) {
            return 'paid';
        } else {
            return 'partial';
        }
    }
    
    // Check if item is fully paid
    public function getIsFullyPaidAttribute()
    {
        return $this->payment_status === 'paid';
    }
    
    // Check if item can accept more payments
    public function getCanAcceptPaymentAttribute()
    {
        return $this->remaining_amount > 0;
    }
}