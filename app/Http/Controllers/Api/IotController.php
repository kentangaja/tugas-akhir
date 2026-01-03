<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;

class IotController extends Controller
{
    public function send(Request $request)
    {
        $device = Device::where('api_key', $request->api_key)->first();

        if (!$device) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        SensorData::create([
            'device_id' => $device->id,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'soil' => $request->soil
        ]);

        $fan = false;
        if (!is_null($device->fan_threshold) && !is_null($request->temperature)) {
            $fan = $request->temperature > $device->fan_threshold;
        }

        $pump = false;
        if (!is_null($device->soil_threshold) && !is_null($request->soil)) {
            $pump = $request->soil < $device->soil_threshold;
        }

        return response()->json([
            'fan' => $fan,
            'pump' => $pump
        ]);
    }
}
