<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #063b2a 0%, #0a5c42 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .field:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: bold;
            color: #063b2a;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .field-value {
            color: #555;
            font-size: 16px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
        }
        .badge {
            display: inline-block;
            background-color: #d4e9d4;
            color: #063b2a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌿 Pesan Kontak Baru</h1>
            <p style="margin: 10px 0 0 0;">Dari Vertemaison Contact Form</p>
        </div>

        <div class="content">
            <p>Halo,</p>
            <p>Ada pesan baru yang masuk melalui form kontak website. Berikut detail pengirimannya:</p>

            <div class="field">
                <div class="field-label">👤 Nama</div>
                <div class="field-value">{{ $contactData['name'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">📧 Email</div>
                <div class="field-value"><a href="mailto:{{ $contactData['email'] }}">{{ $contactData['email'] }}</a></div>
            </div>

            @if (!empty($contactData['phone']))
            <div class="field">
                <div class="field-label">📱 Nomor Telepon</div>
                <div class="field-value"><a href="tel:{{ $contactData['phone'] }}">{{ $contactData['phone'] }}</a></div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">📝 Subjek</div>
                <div class="field-value">
                    {{ ucfirst($contactData['subject']) }}
                    <span class="badge">{{ $contactData['subject'] }}</span>
                </div>
            </div>

            <div class="field">
                <div class="field-label">💬 Pesan</div>
                <div class="field-value">{{ $contactData['message'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem kontak Vertemaison. Jangan balas email ini, silakan hubungi pengirim melalui informasi kontak di atas.</p>
            <p style="margin-top: 15px; border-top: 1px solid #ddd; padding-top: 15px;">
                © {{ date('Y') }} Vertemaison. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
