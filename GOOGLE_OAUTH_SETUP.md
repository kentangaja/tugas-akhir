# Setup Google OAuth untuk Verte-Maison

## Langkah-Langkah Setup

### 1. Buat Google OAuth Application

1. Buka [Google Cloud Console](https://console.cloud.google.com)
2. Buat project baru atau gunakan project yang sudah ada
3. Pergi ke **APIs & Services** → **OAuth consent screen**
4. Pilih **External** sebagai user type
5. Isi informasi yang diperlukan:
   - App name: `Verte-Maison`
   - User support email: Email Anda
   - Developer contact: Email Anda

### 2. Buat OAuth Credentials

1. Pergi ke **APIs & Services** → **Credentials**
2. Klik **Create Credentials** → **OAuth client ID**
3. Pilih **Web Application**
4. Isi authorized JavaScript origins dan redirect URI:
   ```
   Authorized JavaScript origins:
   - http://localhost
   - http://localhost:8000
   - [production-domain.com]
   
   Authorized redirect URIs:
   - http://localhost:8000/auth/google/callback
   - [https://production-domain.com/auth/google/callback]
   ```
5. Copy **Client ID** dan **Client Secret**

### 3. Konfigurasi Environment Variables

Edit file `.env` di root project dan tambahkan:

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Untuk production, ubah `http://localhost:8000` dengan domain Anda:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### 4. Enable Google+ API

1. Di Google Cloud Console, pergi ke **APIs & Services** → **Library**
2. Search untuk "Google+ API"
3. Klik dan pilih **Enable**

### 5. Testing

1. Jalankan aplikasi: `npm run dev` dan `php artisan serve`
2. Pergi ke halaman Login atau Register
3. Klik tombol "Login dengan Google" atau "Daftar dengan Google"
4. Anda seharusnya akan diarahkan ke halaman login Google
5. Setelah sukses login, Anda akan diarahkan kembali ke dashboard

## Fitur yang Sudah Ditambahkan

✅ **Google OAuth Login & Register**
- User dapat login/register dengan akun Google mereka
- Automatic email verification ketika login dengan Google
- Profile information (name, email) tersimpan otomatis

✅ **Updated Navbar**
- Mobile navbar sekarang menampilkan semua menu (Home, Tutorial, Devices)
- Login/Register links kini tampil di mobile menu
- Selaras dengan tampilan desktop

✅ **Dark Mode Removed**
- Tailwind dark mode configuration dihilangkan
- Semua dark: classes dihapus dari views
- Interface sekarang menggunakan light mode saja

## Troubleshooting

### Jika mendapat error "Invalid redirect URI"
- Pastikan redirect URI di Google Console sama persis dengan di `.env`
- Periksa protokol (http vs https)
- Pastikan tidak ada trailing slash

### Jika login Google tidak bekerja
- Verifikasi Client ID dan Secret di `.env`
- Pastikan Google+ API sudah di-enable
- Clear cache Laravel: `php artisan cache:clear`

### Token expired
- Google token akan di-simpan di database
- Untuk refresh token, Anda dapat menambahkan refresh logic di GoogleAuthController jika diperlukan
