<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $devices = auth()->user()->devices;
        } else {
            $devices = collect();
        }

        return view('devices.index', compact('devices'));
    }

    public function show(Device $device)
    {
        $latest = $device->sensorData()->latest()->first();

        $history = $device->sensorData()
                        ->latest()
                        ->take(15) 
                        ->get()
                        ->reverse();

        $labels = $history->pluck('created_at')->map(function($date) {
            return $date->format('H:i');
        });
        
        $tempData = $history->pluck('temperature');
        $humData = $history->pluck('humidity');

        return view('devices.show', compact('device', 'latest', 'labels', 'tempData', 'humData'));
    }

    public function code(Device $device)
    {
        return view('devices.code', compact('device'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
            'fan_threshold' => 'nullable|numeric',
            'soil_threshold' => 'nullable|integer',
        ]);

        auth()->user()->devices()->create([
            'device_name' => $request->device_name,
            'api_key' => Str::uuid(),
            'fan_threshold' => $request->fan_threshold,
            'soil_threshold' => $request->soil_threshold,
        ]);

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil ditambahkan');
    }

    public function getLatestData(Device $device)
    {
        // Authorize: pastikan user punya device ini
        if ($device->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

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
