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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable();
            $table->enum('payment_type', ['cash', 'card', 'bank_transfer', 'cheque', 'online'])->default('cash');
            $table->text('remark')->nullable();
            $table->string('attachment')->nullable();
            $table->decimal('total_paid_amount', 12, 2)->default(0);
            $table->foreignId('paid_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('sites')->cascadeOnDelete();
            $table->string('transaction_id')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
