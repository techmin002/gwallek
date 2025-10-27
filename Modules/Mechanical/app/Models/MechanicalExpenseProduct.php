<?php

namespace Modules\Mechanical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Mechanical\Database\Factories\MechanicalExpenseProductFactory;

class MechanicalExpenseProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'mechanical_expense_id',
        'name',
        'title',
        'amount',
        'quantity',
        'total',
    ];

    // Relation: Product belongs to Expense
    public function expense()
    {
        return $this->belongsTo(MechanicalExpense::class, 'mechanical_expense_id');
    }

    // protected static function newFactory(): MechanicalExpenseProductFactory
    // {
    //     // return MechanicalExpenseProductFactory::new();
    // }
}
