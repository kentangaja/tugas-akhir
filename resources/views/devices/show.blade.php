@extends('layouts.app')

@section('content')
<div class="container text-white">
    <h2>Device: {{ $device->device_name }}</h2>

    <h3>Threshold Settings</h3>
    <ul>
        <li>Fan Threshold: {{ $device->fan_threshold ?? '-' }} °C</li>
        <li>Soil Threshold: {{ $device->soil_threshold ?? '-' }}</li>
    </ul>

    <h3>Latest Sensor Data</h3>

    @if($latest)
        <ul>
            <li>Temperature: {{ $latest->temperature ?? '-' }} °C</li>
            <li>Humidity: {{ $latest->humidity ?? '-' }} %</li>
            <li>Soil: {{ $latest->soil ?? '-' }}</li>
            <li>Time: {{ $latest->created_at }}</li>
        </ul>
    @else
        <p>No data received yet.</p>
    @endif

    <hr>

    <a href="{{ route('devices.code', $device->id) }}">
        View ESP8266 Source Code
    </a>
</div>
@endsection
