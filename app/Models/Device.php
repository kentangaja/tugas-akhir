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
        'soil_threshold'
    ];

    protected $casts = [
        'fan_threshold' => 'float',
        'soil_threshold' => 'integer',
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
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG(temperature) as avg_temperature'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(soil) as avg_soil'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
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
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('AVG(temperature) as avg_temperature'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(soil) as avg_soil'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get();
    }
}
