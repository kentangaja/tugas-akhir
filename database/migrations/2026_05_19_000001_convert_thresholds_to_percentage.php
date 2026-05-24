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
            // Drop old unused column
            $table->dropColumn('soil_threshold');
            
            // Modify soil thresholds to store percentage values (0-100)
            // Change from integer to tinyInteger for better storage
            $table->dropColumn(['soil_dry_threshold', 'soil_wet_threshold']);
        });

        Schema::table('devices', function (Blueprint $table) {
            // Add back with correct type: percentage (0-100%)
            // soil_dry_threshold: % at which soil is considered dry (pump activates) - default 70%
            // soil_wet_threshold: % at which soil is considered wet (pump stops) - default 40%
            $table->tinyInteger('soil_dry_threshold')->nullable()->default(70)->comment('Soil moisture % for dry condition (pump activates)');
            $table->tinyInteger('soil_wet_threshold')->nullable()->default(40)->comment('Soil moisture % for wet condition (pump stops)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['soil_dry_threshold', 'soil_wet_threshold']);
            $table->integer('soil_threshold')->nullable();
            $table->integer('soil_dry_threshold')->default(750);
            $table->integer('soil_wet_threshold')->default(500);
        });
    }
};
