<?php

namespace Modules\Mechanical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Mechanical\Database\Factories\MechanicalExpenseFactory;

class MechanicalExpense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'mechanical_id',
        'bank_id',
        'title',
        'amount',
        'payment_method',
        'cheque_number',
        'receipt',
        'date',
        'description',
        'created_by',
        'status',
    ];


    // Relation: Expense belongs to Mechanical
    public function mechanical()
    {
        return $this->belongsTo(Mechanical::class, 'mechanical_id');
    }

    // Relation: Expense has many Products
    public function products()
    {
        return $this->hasMany(MechanicalExpenseProduct::class, 'mechanical_expense_id');
    }

    // protected static function newFactory(): MechanicalExpenseFactory
    // {
    //     // return MechanicalExpenseFactory::new();
    // }
}
