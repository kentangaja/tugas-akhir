<x-mail::message>
# Peringatan: Suhu Tinggi Terdeteksi

Halo {{ $device->user->name }},

Kami ingin memberitahu bahwa **suhu tinggi terus menerus** telah terdeteksi pada stasiun **{{ $device->device_name }}** selama {{ $durationMinutes }} menit terakhir.

## Detail Informasi:

- **Nama Stasiun:** {{ $device->device_name }}
- **Suhu Saat Ini:** {{ number_format($currentTemp, 1) }}°C
- **Batas Suhu:** {{ number_format($threshold, 1) }}°C
- **Durasi Suhu Tinggi:** {{ $durationMinutes }} menit
- **Waktu Laporan:** {{ now()->format('d M Y H:i:s') }}

## Rekomendasi:

1. Periksa sistem pendingin (kipas) stasiun Anda
2. Pastikan sirkulasi udara berfungsi dengan baik
3. Cek kebocoran atau masalah pada sistem cooling
4. Pertimbangkan untuk menyesuaikan pengaturan threshold jika diperlukan

Anda dapat melihat detail lengkap dan history data sensor dengan mengunjungi dashboard stasiun.

<x-mail::button url="{{ route('devices.show', $device->id) }}" color="success">
Lihat Dashboard Stasiun
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
