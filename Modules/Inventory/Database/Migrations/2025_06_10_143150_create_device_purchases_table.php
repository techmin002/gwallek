<?php
// FILE: 2025_06_10_143150_create_device_purchases_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDevicePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('device_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('bill_no');
            $table->decimal('total_amount', 15, 2);
            $table->string('receipt')->nullable();
            $table->boolean('status')->default(true);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('device_purchases');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

