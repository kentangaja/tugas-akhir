<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Receive sensor data from ESP8266
     */
    public function store(Request $request)
    {
        // Verify API key - dari Bearer Token atau dari JSON body
        $apiKey = $request->bearerToken() ?? $request->input('api_key');
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is required',
            ], 401);
        }

        $device = Device::where('api_key', $apiKey)->first();
        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key',
            ], 401);
        }

        // Validate sensor data
        $validated = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil' => 'required|integer',
        ]);

        // Calculate fan and pump status based on thresholds
        $fan = false;
        if (!is_null($device->fan_threshold) && !is_null($validated['temperature'])) {
            $fan = $validated['temperature'] > $device->fan_threshold;
        }

        $pump = false;
        if (!is_null($device->soil_dry_threshold) && !is_null($validated['soil'])) {
            // Convert soil to moisture percentage (0-1023 to 0-100)
            // High sensor value = dry = low moisture, Low sensor value = wet = high moisture
            $moisturePercentage = 100 - ($validated['soil'] / 1023) * 100;
            $pump = $moisturePercentage < $device->soil_dry_threshold;
        }

        // Store sensor data with fan and pump status
        $sensorData = $device->sensorData()->create([
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
            'soil' => $validated['soil'],
            'fan_status' => $fan,
            'pump_status' => $pump,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sensor data received',
            'data' => $sensorData,
            'fan' => $fan,
            'pump' => $pump,
        ]);
    }

    /**
     * Get sensor data history with optional filtering
     */
    public function getHistory($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);

        $query = $device->sensorData();

        // Filter by date range
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get aggregated data for dashboard
     */
    public function getDashboardData($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);

        // Get latest sensor reading
        $latest = $device->sensorData()->latest()->first();

        // Get week data for graph
        $weekData = $device->sensorData()
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at')
            ->get()
            ->map(function ($data) {
                return [
                    'timestamp' => $data->created_at,
                    'temperature' => $data->temperature,
                    'humidity' => $data->humidity,
                    'soil' => $data->soil,
                ];
            });

        // Calculate statistics
        $stats = $device->sensorData()
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('
                AVG(temperature) as avg_temperature,
                MAX(temperature) as max_temperature,
                MIN(temperature) as min_temperature,
                AVG(humidity) as avg_humidity,
                AVG(soil) as avg_soil
            ')
            ->first();

        return response()->json([
            'success' => true,
            'device' => [
                'id' => $device->id,
                'name' => $device->device_name,
                'fan_threshold' => $device->fan_threshold,
                'soil_threshold' => $device->soil_threshold,
            ],
            'current' => [
                'temperature' => $latest?->temperature ?? null,
                'humidity' => $latest?->humidity ?? null,
                'soil' => $latest?->soil ?? null,
                'updated_at' => $latest?->created_at ?? null,
            ],
            'statistics' => [
                'avg_temperature' => round($stats->avg_temperature ?? 0, 2),
                'max_temperature' => round($stats->max_temperature ?? 0, 2),
                'min_temperature' => round($stats->min_temperature ?? 0, 2),
                'avg_humidity' => round($stats->avg_humidity ?? 0, 2),
                'avg_soil' => round($stats->avg_soil ?? 0, 2),
            ],
            'chart_data' => $weekData,
        ]);
    }

    /**
     * Get latest sensor data
     */
    public function getLatest($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);
        $latest = $device->sensorData()->latest()->first();

        if (!$latest) {
            return response()->json([
                'success' => false,
                'message' => 'No sensor data available',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $latest,
        ]);
    }
}
