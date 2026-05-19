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
        'fan_threshold',
        'soil_dry_threshold',
        'soil_wet_threshold'
    ];

    protected $casts = [
        'fan_threshold' => 'float',
        'soil_dry_threshold' => 'integer',
        'soil_wet_threshold' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
     * Get temperature data with filters (date range, temperature)
     */
    public function getFilteredTemperatureData($startDate = null, $endDate = null, $minTemp = null, $maxTemp = null)
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
}
