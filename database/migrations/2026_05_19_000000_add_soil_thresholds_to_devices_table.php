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
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('soil_dry_threshold')->nullable()->default(750)->after('soil_threshold')->comment('ADC value threshold for dry soil');
            $table->integer('soil_wet_threshold')->nullable()->default(500)->after('soil_dry_threshold')->comment('ADC value threshold for wet soil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['soil_dry_threshold', 'soil_wet_threshold']);
        });
    }
};
