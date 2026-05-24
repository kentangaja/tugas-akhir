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
        'pump_status',
        'fan_status',
    ];

    protected $casts = [
        'pump_status' => 'boolean',
        'fan_status' => 'boolean',
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

    /**
     * Get pump status indicator text
     */
    public function getPumpStatusIndicator()
    {
        return $this->pump_status ? 'Aktif' : 'Mati';
    }

    /**
     * Get pump status badge color
     */
    public function getPumpStatusColor()
    {
        return $this->pump_status ? 'emerald' : 'gray';
    }

    /**
     * Get fan status indicator text
     */
    public function getFanStatusIndicator()
    {
        return $this->fan_status ? 'Aktif' : 'Mati';
    }

    /**
     * Get fan status badge color
     */
    public function getFanStatusColor()
    {
        return $this->fan_status ? 'blue' : 'gray';
    }
}
