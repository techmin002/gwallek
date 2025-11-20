<?php
// ============================================================
// FILE: 2025_06_10_143220_create_device_purchase_accessories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('device_purchase_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_purchase_id');
            $table->unsignedBigInteger('accessory_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();
            
            // Add foreign key to device_purchases
            $table->foreign('device_purchase_id')
                ->references('id')
                ->on('device_purchases')
                ->cascadeOnDelete();
            
            // Add foreign key to accessories if table exists
            if (Schema::hasTable('accessories')) {
                $table->foreign('accessory_id')
                    ->references('id')
                    ->on('accessories')
                    ->cascadeOnDelete();
            }
            
            // Add foreign key to branches if table exists
            if (Schema::hasTable('branches')) {
                $table->foreign('branch_id')
                    ->references('id')
                    ->on('branches')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('device_purchase_accessories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};