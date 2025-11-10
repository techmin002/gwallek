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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Site Name
            $table->decimal('amount', 12, 2);     // Amount
            $table->date('start_date');           // Start Date
            $table->date('end_date')->nullable();             // End Date
            $table->string('image')->nullable();  // Site Image
            $table->string('contract_image')->nullable(); // Contract Paper
            $table->text('description')->nullable();
            $table->unsignedBigInteger('branch_id');     // FK
            $table->unsignedBigInteger('assign_to');     // Staff/User
            $table->unsignedBigInteger('customer_id');   // FK
            $table->enum('status', ['on', 'off'])->default('on');
            $table->timestamps();

            // Foreign keys
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
