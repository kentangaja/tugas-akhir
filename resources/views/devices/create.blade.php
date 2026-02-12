<x-app-layout>
    <div class="container">
        <h2 class="text-white text-xl">Tambah Device</h2>

        <form method="POST" action="{{ route('devices.store') }}">
            @csrf

            <div>
                <label class="text-white" >Nama Device</label><br>
                <input type="text" name="device_name" required>
            </div>

            <br>

            <div>
                <label class="text-white" >Batas Suhu Kipas (opsional)</label><br>
                <input type="number" step="0.1" name="fan_threshold">
            </div>

            <br>

            <div>
                <label class="text-white" >Batas Kelembaban Tanah (opsional)</label><br>
                <input type="number" name="soil_threshold">
            </div>

            <br>

            <button type="submit">Simpan</button>
        </form>
    </div>
</x-app-layout>
