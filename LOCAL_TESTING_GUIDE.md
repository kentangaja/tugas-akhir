# Panduan Verifikasi: Lokal & Hosting (Laravel + ESP8266)

Dokumen ini merangkum pengecekan dan langkah debugging untuk dua skenario:
- Testing lokal (ESP8266 terhubung ke PC/dev server di jaringan lokal)
- Setelah di-hosting (domain publik, HTTPS)

Ringkas: ESP8266 harus mengakses IP atau domain yang dapat dicapai dari jaringan Wi‑Fi tempat ESP berada. Jangan gunakan `127.0.0.1`/`localhost` pada ESP.

## 1. Persiapan singkat

- Pastikan aplikasi Laravel sudah ter-setup (migrasi, .env, dependencies).
- Konfigurasi ESP8266:
  - `ssid`, `password` — WiFi yang sama dengan PC/server
  - `serverDomain` — IP PC (192.168.x.x) saat lokal, atau domain saat hosting
  - `serverPort` — port Laravel (mis. `8000` untuk `php artisan serve`)
  - `apiKey` — copy dari halaman `My Devices` (tombol 📋)

## 2. Verifikasi Lokal (development)

Langkah yang perlu diperiksa dan perintah yang bisa dijalankan di PC (Windows PowerShell):

1) Jalankan Laravel dev server di seluruh interface:
```powershell
cd C:\tugas-akhir
php artisan serve --host=0.0.0.0 --port=8000
```

2) Periksa IP laptop (pakai IP, bukan localhost):
```powershell
ipconfig
```
Catat `IPv4 Address` (mis. `192.168.1.4`). Gunakan IP ini di `serverDomain` pada kode ESP.

3) Cek apakah server mendengarkan port 8000:
```powershell
netstat -ano | findstr ":8000"
```
Jika tidak ada listing `0.0.0.0:8000` atau `192.168.1.15:8000`, ulangi langkah (1).

4) Uji endpoint dari PC (verbose):
```powershell
# GET root
curl -v http://192.168.1.4:8000/

# POST ke endpoint sensor-data (ganti <API_KEY>)
curl -v -X POST "http://192.168.1.4:8000/api/sensor-data" \
  -H "Authorization: Bearer <API_KEY>" \
  -H "Content-Type: application/json" \
  -d '{"temperature":27.3,"humidity":76,"soil":4}'
```

Jika `curl` dari PC berhasil (HTTP 200/201), namun ESP masih gagal, lakukan langkah 5.

5) Periksa firewall Windows (izinkan port 8000 inbound) — jalankan PowerShell sebagai Administrator:
```powershell
New-NetFirewallRule -DisplayName "Allow-Laravel-8000" -Direction Inbound -LocalPort 8000 -Protocol TCP -Action Allow
```

6) Router: pastikan "AP/client isolation" atau "Wireless Isolation" dimatikan agar client bisa mengakses PC.

7) Band Wi‑Fi: ESP8266 hanya bekerja di 2.4GHz — pastikan laptop juga terhubung ke 2.4GHz atau router bridged.

8) Periksa Serial Monitor ESP (115200):
- Pastikan ESP menampilkan IP lokalnya (`WiFi.localIP()`)
- Pastikan URL yang dicetak berformat `http://<IP_PC>:8000/api/sensor-data`
- Jika masih `connection failed`, paste log serial di sini.

## 3. Verifikasi jika sudah di-hosting (production)

Perbedaan utama: domain publik, HTTPS, firewall hosting.

1) Gunakan domain atau IP publik (mis. `https://iot.example.com`).
2) Pastikan sertifikat TLS valid (Let's Encrypt atau lainnya) — gunakan `https://` di ESP (WiFiClientSecure) dan jangan `setInsecure()` kecuali untuk testing.
3) Endpoint harus dapat menerima request dari internet — periksa hosting provider firewall, nginx/apache config, CORS jika ada frontend.
4) Uji dari luar jaringan (ponsel dengan data seluler) menggunakan `curl` atau `Postman`:
```bash
curl -v -X POST "https://iot.example.com/api/sensor-data" \
  -H "Authorization: Bearer <API_KEY>" \
  -H "Content-Type: application/json" \
  -d '{"temperature":27.3,"humidity":76,"soil":4}'
```
5) Jika hosting di balik reverse proxy (nginx), pastikan `proxy_set_header Authorization $http_authorization;` (nginx) diteruskan ke PHP.

## 4. Konfigurasi ESP contoh (ringkas)

Contoh pengaturan untuk testing lokal (`code.blade.php` sudah menampilkan contoh):
```cpp
const char* ssid = "WIFI_ANDA";
const char* password = "PASSWORD_WIFI_ANDA";
const char* serverDomain = "192.168.1.4"; // IP laptop (sesuaikan dengan hasil ipconfig)
const int serverPort = 8000;
const char* serverPath = "/api/sensor-data";
const char* apiKey = "PASTE_API_KEY";

// URL build
String url = String("http://") + serverDomain + ":" + String(serverPort) + serverPath;
```

Untuk hosting (HTTPS):
```cpp
String url = String("https://") + serverDomain + serverPath; // gunakan WiFiClientSecure
```

## 5. Debug cepat checklist

- [x] `curl` dari PC ke `http://192.168.1.4:8000/api/sensor-data` berhasil ✅
- [x] `php artisan serve` menampilkan `Server running on [http://0.0.0.0:8000]` ✅
- [ ] `netstat` menunjukkan listener pada port 8000
- [x] Firewall Windows mengizinkan port 8000 ✅
- [ ] Router tidak mengaktifkan client isolation ⚠️ **PERIKSA INI**
- [ ] ESP dan PC pada jaringan dan band yang sama (2.4GHz) ⚠️ **PERIKSA INI**

## 6. Jika masih gagal — informasi yang saya perlukan
Kirimkan output berikut agar saya bantu analisa:

1. Hasil `curl -v` dari PC (copy-paste seluruh output).
2. Hasil `netstat -ano | findstr ":8000"`.
3. Potongan Serial Monitor ESP (baris IP, URL yang dikirim, dan error).
4. Output `php artisan serve` bila ada pesan error.

Dengan informasi di atas saya akan beri langkah spesifik (rule firewall, setting router, atau alternatif seperti `ngrok`/port-forward).

---

Jika mau saya juga bisa menambahkan skrip PowerShell kecil untuk automasi pengecekan (netstat + curl), mau saya tambahkan?