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
        Schema::table('sites', function (Blueprint $table) {
            $table->string('location')->nullable()->after('name');
            $table->string('progress_status')->nullable()->after('status');
            $table->string('project_area')->nullable()->after('progress_status');
            $table->string('contract_id')->nullable()->after('project_area');
            $table->longText('overview')->nullable()->after('contract_id');
            $table->longText('key_features')->nullable()->after('overview');
            $table->longText('technical_specifications')->nullable()->after('key_features');
            $table->longText('environmental_impact')->nullable()->after('technical_specifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'progress_status',
                'project_area',
                'contract_id',
                'overview',
                'key_features',
                'technical_specifications',
                'environmental_impact',
            ]);
        });
    }
};
