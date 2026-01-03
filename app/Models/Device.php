<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'user_id',
        'device_name',
        'api_key',
        'fan_threshold',
        'soil_threshold'
    ];

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }
}
