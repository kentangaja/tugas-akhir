<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $fillable = [
        'device_id',
        'temperature',
        'humidity',
        'soil',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get temperature status indicator (Panas/Normal)
     * Threshold: > 30°C = Panas, <= 30°C = Normal
     */
    public function getTemperatureStatus()
    {
        if ($this->temperature > 30) {
            return 'Panas';
        }
        return 'Normal';
    }

    /**
     * Get temperature status badge color
     */
    public function getTemperatureStatusColor()
    {
        if ($this->temperature > 30) {
            return 'red';
        }
        return 'green';
    }
}
