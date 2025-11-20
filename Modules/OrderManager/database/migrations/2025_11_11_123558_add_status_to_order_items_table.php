<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'partial_purchased',
                'full_purchased'
            ])->default('pending')->change();

            if (!Schema::hasColumn('order_items', 'purchased_quantity')) {
                $table->decimal('purchased_quantity', 10, 2)->nullable()->after('quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','purchased'])->default('pending')->change();
            $table->dropColumn('purchased_quantity');
        });
    }
};
