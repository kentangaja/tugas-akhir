@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Device</h2>

    <form method="POST" action="{{ route('devices.store') }}">
        @csrf

        <div>
            <label>Nama Device</label><br>
            <input type="text" name="device_name" required>
        </div>

        <br>

        <div>
            <label>Batas Suhu Kipas (opsional)</label><br>
            <input type="number" step="0.1" name="fan_threshold">
        </div>

        <br>

        <div>
            <label>Batas Kelembaban Tanah (opsional)</label><br>
            <input type="number" name="soil_threshold">
        </div>

        <br>

        <button type="submit">Simpan</button>
    </form>
</div>
@endsection
