<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

    public function show(Device $device, Request $request)
    {
        $latest = $device->sensorData()->latest()->first();

        // Get filtered data if filters are applied
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $minTemp = $request->input('min_temp');
        $maxTemp = $request->input('max_temp');

        if ($startDate || $endDate || $minTemp || $maxTemp) {
            $weeklyData = $device->getFilteredTemperatureData($startDate, $endDate, $minTemp, $maxTemp);
        } else {
            $weeklyData = $device->getWeeklyTemperatureByDay();
        }

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

        return view('devices.show', compact('device', 'latest', 'labels', 'tempData', 'humData', 'weeklyData', 'startDate', 'endDate', 'minTemp', 'maxTemp'));
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
            'fan_threshold' => 'nullable|numeric|min:0|max:50',
            'soil_dry_threshold' => 'nullable|integer|min:0|max:100',
            'soil_wet_threshold' => 'nullable|integer|min:0|max:100',
        ]);

        /** @var User $user */
        $user = Auth::user();
        
        $user->devices()->create([
            'device_name' => $request->device_name,
            'api_key' => Str::uuid(),
            'fan_threshold' => $request->fan_threshold,
            'soil_dry_threshold' => $request->soil_dry_threshold ?? 70,
            'soil_wet_threshold' => $request->soil_wet_threshold ?? 40,
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
            'fan_threshold' => 'nullable|numeric|min:0|max:50',
            'soil_dry_threshold' => 'nullable|integer|min:0|max:100',
            'soil_wet_threshold' => 'nullable|integer|min:0|max:100',
        ]);

        $device->update([
            'device_name' => $request->device_name,
            'fan_threshold' => $request->fan_threshold,
            'soil_dry_threshold' => $request->soil_dry_threshold ?? $device->soil_dry_threshold,
            'soil_wet_threshold' => $request->soil_wet_threshold ?? $device->soil_wet_threshold,
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
            'temperature_status' => $latest->getTemperatureStatus(),
            'status_color' => $latest->getTemperatureStatusColor(),
        ]);
    }

    public function exportPDF(Device $device, Request $request)
    {
        // Authorize: pastikan user punya device ini
        if ($device->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $minTemp = $request->input('min_temp');
        $maxTemp = $request->input('max_temp');

        // Get filtered data
        if ($startDate || $endDate || $minTemp || $maxTemp) {
            $sensorData = $device->getFilteredTemperatureData($startDate, $endDate, $minTemp, $maxTemp);
        } else {
            $sensorData = $device->getWeeklyTemperatureByDay();
        }

        $pdf = Pdf::loadView('devices.export-pdf', [
            'device' => $device,
            'sensorData' => $sensorData,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'minTemp' => $minTemp,
            'maxTemp' => $maxTemp,
        ]);

        return $pdf->download('sensor-data-' . $device->device_name . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
