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
        Schema::create('mechanical_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mechanical_id');
            $table->string('title');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('payment_method');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('cheque_number')->nullable();
            $table->string('receipt')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('status')->default('on');

            $table->foreign('mechanical_id')
                ->references('id')->on('mechanicals')
                ->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_expenses');
    }
};
