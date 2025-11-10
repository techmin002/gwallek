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
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->text('overview')->nullable();
            $table->text('benifits')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};
