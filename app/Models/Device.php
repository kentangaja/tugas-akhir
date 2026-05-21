<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Device extends Model
{
    protected $fillable = [
        'user_id',
        'device_name',
        'api_key',
        'is_active',
        'fan_threshold',
        'soil_dry_threshold',
        'soil_wet_threshold',
        'high_temp_threshold',
        'high_temp_duration',
        'last_high_temp_notification'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fan_threshold' => 'float',
        'soil_dry_threshold' => 'integer',
        'soil_wet_threshold' => 'integer',
        'high_temp_threshold' => 'integer',
        'high_temp_duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_high_temp_notification' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }

    /**
     * Get average sensor data for this week (last 7 days)
     */
    public function getWeeklyAverageTemperature()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        
        return $this->sensorData()
            ->where('created_at', '>=', $sevenDaysAgo)
            ->avg('temperature');
    }

    /**
     * Get average sensor data for today
     */
    public function getDailyAverageTemperature()
    {
        $today = Carbon::today();
        
        return $this->sensorData()
            ->whereDate('created_at', $today)
            ->avg('temperature');
    }

    /**
     * Get weekly temperature data grouped by day
     */
    public function getWeeklyTemperatureByDay()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        
        return $this->sensorData()
            ->where('created_at', '>=', $sevenDaysAgo)
            ->select(
                DB::raw('created_at::date as date'),
                DB::raw('AVG(temperature) as avg_temperature'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(soil) as avg_soil'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('created_at::date'))
            ->orderBy('date')
            ->get();
    }

    /**
     * Get temperature data with filters (date range, temperature, soil)
     */
    public function getFilteredTemperatureData($startDate = null, $endDate = null, $minTemp = null, $maxTemp = null, $tempCondition = null, $specificTemp = null, $soilCondition = null)
    {
        $query = $this->sensorData();

        if ($startDate) {
            $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        if ($minTemp !== null) {
            $query->where('temperature', '>=', $minTemp);
        }

        if ($maxTemp !== null) {
            $query->where('temperature', '<=', $maxTemp);
        }

        // Filter berdasarkan kondisi suhu (panas/dingin)
        if ($tempCondition === 'panas') {
            $threshold = $this->fan_threshold ?? 30;
            $query->where('temperature', '>', $threshold);
        } elseif ($tempCondition === 'dingin') {
            $threshold = $this->fan_threshold ?? 30;
            $query->where('temperature', '<', $threshold);
        }

        // Filter berdasarkan suhu spesifik dengan toleransi
        if ($specificTemp !== null) {
            $tolerance = 2;
            $query->whereBetween('temperature', [$specificTemp - $tolerance, $specificTemp + $tolerance]);
        }

        // Filter berdasarkan kondisi kelembaban tanah (kering/basah)
        // Soil moisture % = 100 - (soil_raw / 1023) * 100
        if ($soilCondition === 'dry') {
            $threshold = $this->soil_dry_threshold ?? 70;
            // Kering = moisture % < dry_threshold
            // moisture% < threshold => 100 - (soil/1023)*100 < threshold => soil > (1023 * (100-threshold) / 100)
            $soilRawThreshold = (int)((1023 * (100 - $threshold)) / 100);
            $query->where('soil', '>', $soilRawThreshold);
        } elseif ($soilCondition === 'wet') {
            $threshold = $this->soil_wet_threshold ?? 40;
            // Basah = moisture % > wet_threshold
            // moisture% > threshold => 100 - (soil/1023)*100 > threshold => soil < (1023 * (100-threshold) / 100)
            $soilRawThreshold = (int)((1023 * (100 - $threshold)) / 100);
            $query->where('soil', '<', $soilRawThreshold);
        }

        return $query
            ->select(
                // Ganti DATE(created_at) menjadi created_at::date
                DB::raw('created_at::date as date'), 
                DB::raw('AVG(temperature) as avg_temperature'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(soil) as avg_soil'),
                DB::raw('COUNT(*) as count')
            )
            // GroupBy juga harus disesuaikan agar sama dengan Select
            ->groupBy(DB::raw('created_at::date'))
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get average temperature indicator status
     */
    public function getAverageTemperatureStatus($avgTemp = null)
    {
        if ($avgTemp === null) {
            $avgTemp = $this->getWeeklyAverageTemperature();
        }

        if ($avgTemp > 30) {
            return 'Panas';
        }
        return 'Normal';
    }

    /**
     * Get average temperature status color
     */
    public function getAverageTemperatureStatusColor($avgTemp = null)
    {
        if ($avgTemp === null) {
            $avgTemp = $this->getWeeklyAverageTemperature();
        }

        if ($avgTemp > 30) {
            return 'red';
        }
        return 'green';
    }

    /**
     * Get daily temperature data grouped by hour
     */
    public function getDailyTemperatureByHour()
    {
        $today = Carbon::today();
        
        return $this->sensorData()
            ->whereDate('created_at', $today)
            ->select(
                DB::raw('EXTRACT(HOUR FROM created_at) as hour'), // Perubahan di sini
                DB::raw('AVG(temperature) as avg_temperature'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(soil) as avg_soil'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('EXTRACT(HOUR FROM created_at)')) // Dan di sini
            ->orderBy('hour')
            ->get();
    }

    /**
     * Toggle device active status
     */
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Check if device can be deleted (only inactive devices)
     */
    public function canBeDeleted()
    {
        return !$this->is_active;
    }

    /**
     * Get status indicator text
     */
    public function getStatusIndicator()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return $this->is_active ? 'emerald' : 'gray';
    }

    /**
     * Check if there's an active high temperature condition
     */
    public function isHighTemperatureActive()
    {
        $threshold = $this->high_temp_threshold ?? 35;
        $durationMinutes = $this->high_temp_duration ?? 30;
        $since = Carbon::now()->subMinutes($durationMinutes);

        $highTempCount = $this->sensorData()
            ->where('temperature', '>', $threshold)
            ->where('created_at', '>=', $since)
            ->count();

        return $highTempCount > 0;
    }
}

