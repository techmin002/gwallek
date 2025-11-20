<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Invoice extends Model {
    protected $fillable = [
        'payment_id',
        'invoice_no',
        'file_path',
        'generated_by',
        'generated_at'
    ];

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function generatedBy() {
        return $this->belongsTo(User::class, 'generated_by');
    }
}