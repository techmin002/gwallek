<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');    // project id
            $table->string('title');                  // e.g., First Installment / Final Payment
            $table->decimal('amount', 15, 2);
            $table->date('received_date');
           $table->enum('payment_method', [
    'cash',
    'card',
    'e_wallet',
    'cheque',
    'bank_transfer',
    'other'
])->nullable();
            $table->text('note')->nullable();
            $table->string('receipt_image')->nullable();
            $table->timestamps();

            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
