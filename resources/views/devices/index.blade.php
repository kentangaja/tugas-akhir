@extends('layouts.app')

@section('content')
<div class="container text-white">
    <h2>My Devices</h2>

    <a href="{{ route('devices.create') }}">Add Device</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Device Name</th>
                <th>API Key</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
            <tr>
                <td>{{ $device->device_name }}</td>
                <td>{{ $device->api_key }}</td>
                <td>
                    <a href="{{ route('devices.show', $device->id) }}">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
