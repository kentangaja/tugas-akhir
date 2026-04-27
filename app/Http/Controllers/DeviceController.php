<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $devices = Auth::user()->devices()->with('sensorData')->get();
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

        /** @var User $user */
        $user = Auth::user();
        
        $user->devices()->create([
            'device_name' => $request->device_name,
            'api_key' => Str::uuid(),
            'fan_threshold' => $request->fan_threshold,
            'soil_threshold' => $request->soil_threshold,
        ]);

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil ditambahkan');
    }

    public function edit(Device $device)
    {
        // Check authorization
        if ($device->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        // Check authorization
        if ($device->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'device_name' => 'required|string|max:255',
            'fan_threshold' => 'nullable|numeric',
            'soil_threshold' => 'nullable|integer',
        ]);

        $device->update([
            'device_name' => $request->device_name,
            'fan_threshold' => $request->fan_threshold,
            'soil_threshold' => $request->soil_threshold,
        ]);

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil diperbarui');
    }

    public function destroy(Device $device)
    {
        // Check authorization
        if ($device->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil dihapus');
    }

    public function getLatestData(Device $device)
    {
        // Authorize: pastikan user punya device ini
        if ($device->user_id !== Auth::id()) {
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
