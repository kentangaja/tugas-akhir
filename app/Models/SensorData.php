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
     * Get temperature status indicator (Panas/Normal) based on device threshold
     */
    public function getTemperatureStatus()
    {
        $threshold = $this->device->fan_threshold ?? 30;
        if ($this->temperature > $threshold) {
            return 'Panas';
        }
        return 'Normal';
    }

    /**
     * Get temperature status badge color based on device threshold
     */
    public function getTemperatureStatusColor()
    {
        $threshold = $this->device->fan_threshold ?? 30;
        if ($this->temperature > $threshold) {
            return 'red';
        }
        return 'green';
    }
}
