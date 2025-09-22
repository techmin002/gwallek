<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Branch\Entities\Branch;
use Modules\Finance\Models\Bank;

class Expenses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'title',
        'bank_id',
        'amount',
        'expense_category_id',
        'date',
        'status',
        'descriptions',
        'mode',
        'receipt'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Expenses\Database\factories\ExpensesFactory::new();
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function bank()
{
    return $this->belongsTo(Bank::class);
}
}
