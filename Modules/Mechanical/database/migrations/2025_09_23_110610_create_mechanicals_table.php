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
        Schema::create('mechanicals', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('image')->nullable();

            // Relation with Branch
            $table->unsignedBigInteger('branch_id')->nullable();

            // Purchase Details
            $table->date('purchase_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();

            // Insurance Details
            $table->date('insurance_date')->nullable();
            $table->string('insurance_document')->nullable();

            // Vehicle Details
            $table->string('engine_number')->nullable();
            $table->string('chasis_number')->nullable();
            $table->string('vehicle_number')->nullable();

            // Service
            $table->date('service_date')->nullable();

            // Extra Info
            $table->text('description')->nullable();
            $table->enum('status', ['on', 'off'])->default('off');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('mechanical_categories')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanicals');
    }
};
