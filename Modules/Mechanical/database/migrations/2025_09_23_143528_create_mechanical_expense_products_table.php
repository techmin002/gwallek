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
        Schema::create('mechanical_expense_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mechanical_expense_id'); // FK to mechanical_expenses
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('mechanical_expense_id')
                ->references('id')->on('mechanical_expenses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_expense_products');
    }
};
