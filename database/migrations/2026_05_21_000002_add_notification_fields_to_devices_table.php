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
            $table->integer('high_temp_threshold')->default(35)->after('fan_threshold')->comment('Batas suhu tinggi untuk notifikasi');
            $table->integer('high_temp_duration')->default(30)->after('high_temp_threshold')->comment('Durasi dalam menit sebelum notifikasi dikirim');
            $table->timestamp('last_high_temp_notification')->nullable()->after('high_temp_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['high_temp_threshold', 'high_temp_duration', 'last_high_temp_notification']);
        });
    }
};
