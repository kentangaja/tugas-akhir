@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white p-6">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">My Devices</h2>

            <a href="{{ route('devices.create') }}"
               class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
                + Add Device
            </a>
        </div>

        <!-- Card -->
        <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-700 text-slate-300 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Device Name</th>
                        <th class="px-6 py-4 text-left">API Key</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-700">
                    @forelse ($devices as $device)
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-6 py-4 font-medium">
                                {{ $device->device_name }}
                            </td>

                            <td class="px-6 py-4 font-mono text-emerald-400">
                                {{ Str::limit($device->api_key, 20) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('devices.show', $device->id) }}"
                                   class="inline-block bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-xs font-semibold">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                No devices registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
