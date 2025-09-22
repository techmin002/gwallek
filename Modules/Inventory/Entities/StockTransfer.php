<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Models\Product;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table = 'stock_transfers';
    protected $fillable = [
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,             // Related model
            'stock_transfer_products',  // Pivot table name
            'stock_transfer_id',        // Foreign key on pivot for StockTransfer
            'product_id'                // Foreign key on pivot for Product
        )->withPivot(['quantity', 'serial_numbers', 'condition']);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getTotalQuantityAttribute()
    {
        return $this->products->sum('pivot.quantity');
    }
}
