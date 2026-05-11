# Panduan Konfigurasi Email untuk Contact Form

## Status Saat Ini
Form contact Anda sudah siap dengan:
- ✅ ContactMail class yang menerima data kontak
- ✅ Template email profesional di `resources/views/emails/contact.blade.php`
- ✅ Popup notifikasi otomatis yang hilang dalam 5 detik
- ✅ Penyimpanan data kontak ke database

## Langkah Konfigurasi Email

### Opsi 1: Gmail (Recommended untuk Testing)

1. **Buat App Password di Gmail:**
   - Buka https://myaccount.google.com/security
   - Aktifkan 2-Factor Authentication jika belum
   - Klik "App passwords"
   - Pilih "Mail" dan "Windows Computer"
   - Salin password yang dihasilkan

2. **Update file `.env`:**
   ```
   MAIL_MAILER=smtp
   MAIL_SCHEME=tls
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="Vertemaison"
   ```

3. **Jalankan command:**
   ```bash
   php artisan config:clear
   ```

### Opsi 2: Menggunakan Mailtrap (Untuk Development)

1. **Daftar di https://mailtrap.io**
2. **Ambil SMTP credentials dari dashboard**
3. **Update `.env`:**
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=live.smtp.mailtrap.io
   MAIL_PORT=587
   MAIL_USERNAME=your-username
   MAIL_PASSWORD=your-password
   MAIL_FROM_ADDRESS=your-email@example.com
   MAIL_FROM_NAME="Vertemaison"
   ```

### Opsi 3: Mode Log (Untuk Testing Lokal)

Jika ingin melihat email di log file saja:
```
MAIL_MAILER=log
```

Email akan disimpan di: `storage/logs/laravel.log`

## Testing Form Contact

1. Buka halaman contact di browser
2. Isi form dengan data lengkap
3. Klik tombol "Kirim Pesan"
4. Akan muncul notifikasi popup hijau yang hilang otomatis
5. Email akan dikirim ke: `revicee555@gmail.com`

## Fitur-Fitur yang Sudah Diimplementasi

✅ **Popup Notifikasi**
- Muncul setelah form terkirim
- Otomatis hilang dalam 5 detik
- Bisa ditutup manual dengan tombol X
- Animasi smooth fade in/out

✅ **Email Template**
- Template profesional dan terformat baik
- Menampilkan semua informasi kontak
- Responsive design untuk semua devices

✅ **Validasi Form**
- Name, Email, Subject, Message: Required
- Phone: Optional
- Email validation built-in

✅ **Database Storage**
- Semua data kontak tersimpan di table `contacts`
- Bisa di-review kemudian

## Troubleshooting

### Email tidak terkirim?
1. Periksa `.env` sudah benar
2. Jalankan `php artisan config:clear`
3. Cek apakah port SMTP benar
4. Pastikan firewall tidak memblokir

### Notifikasi tidak muncul?
1. Clear cache browser
2. Check browser console untuk errors
3. Pastikan JavaScript tidak ter-disable

## File yang Telah Dimodifikasi

1. `app/Mail/ContactMail.php` - Updated dengan data handling
2. `resources/views/contact.blade.php` - Added popup notification
3. `resources/views/emails/contact.blade.php` - Created (email template baru)

---
Last Updated: May 11, 2026
