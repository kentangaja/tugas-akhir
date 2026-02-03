# 🌱 Smart Plant IoT System

**Sistem monitoring tanaman otomatis dengan IoT dan kontrol cerdas menggunakan ESP8266 dan sensor pintar.**

![Status](https://img.shields.io/badge/Backend-Complete-green)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![ESP8266](https://img.shields.io/badge/ESP8266-Compatible-blue)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Daftar Isi

- [Overview](#-overview)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Quick Start](#-quick-start)
- [Documentation](#-documentation)
- [Architecture](#-architecture)
- [Status](#-status)

---

## 📌 Overview

Smart Plant IoT adalah sistem komprehensif untuk monitoring tanaman secara real-time dengan kontrol otomatis untuk perangkat seperti fan pendingin dan pompa penyiram. 

**Komponen Utama:**
- 🖥️ **Backend API** - Laravel 11 dengan REST API
- 📱 **Frontend** - React/Vue (TODO)
- 🔌 **Hardware** - ESP8266 D1 R2 Mini dengan sensor DHT22 & soil moisture
- 💾 **Database** - MySQL untuk penyimpanan data sensor

---

## ✨ Fitur Utama

### ✅ Backend (100% Selesai)

#### Authentication & Authorization
- ✓ User registration & login
- ✓ Token-based authentication (Laravel Sanctum)
- ✓ User management
- ✓ Secure API endpoints

#### Device Management
- ✓ Create/Read/Update/Delete devices
- ✓ Auto-generate unique API keys
- ✓ Device thresholds configuration
- ✓ Auto-generate Arduino code untuk ESP8266

#### Sensor Data Collection
- ✓ Real-time data from ESP8266
- ✓ Store temperature, humidity, soil moisture
- ✓ Historical data dengan date range filtering
- ✓ 7-day statistics & aggregation

#### Smart Control
- ✓ Temperature-based fan control
- ✓ Soil moisture-based pump control
- ✓ Hysteresis logic untuk mencegah switching
- ✓ Customizable thresholds

#### Analytics & Dashboard
- ✓ Real-time sensor readings
- ✓ 7-day statistics (avg, max, min)
- ✓ Chart data untuk visualisasi
- ✓ Device status monitoring

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 11
- **Authentication:** Laravel Sanctum
- **Database:** MySQL 8.0+
- **API:** REST API dengan JSON responses
- **Validation:** Laravel form requests

### Frontend (TODO)
- React/Vue (to be decided)
- Axios/Fetch untuk API calls
- Chart.js/Recharts untuk visualisasi
- TailwindCSS untuk styling

### Hardware
- **Microcontroller:** ESP8266 D1 R2 Mini
- **Sensor:** DHT22 (temperature & humidity)
- **Sensor:** Soil Moisture Sensor
- **Control:** 2-Channel Relay Module
- **Communication:** WiFi

### Tools & Libraries
- Postman untuk API testing
- Arduino IDE untuk ESP8266
- Git untuk version control

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+
- Git

### Installation

```bash
# 1. Clone & enter directory
cd c:\tugas-akhir

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database setup
php artisan migrate
php artisan seed:database

# 5. Start server
php artisan serve
```

Server running at: `http://localhost:8000`
API available at: `http://localhost:8000/api`

### Testing API

Import `POSTMAN_COLLECTION.json` ke Postman untuk testing semua endpoints.

```bash
# Quick test - Register & Login
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123"
  }'
```

---

## 📚 Documentation

| Document | Deskripsi |
|----------|-----------|
| [API_DOCUMENTATION.md](API_DOCUMENTATION.md) | Complete API reference dengan request/response examples |
| [BACKEND_SETUP.md](BACKEND_SETUP.md) | Setup instructions & troubleshooting |
| [FRONTEND_INTEGRATION_GUIDE.md](FRONTEND_INTEGRATION_GUIDE.md) | Guide untuk frontend developer |
| [ESP8266_INTEGRATION_GUIDE.md](ESP8266_INTEGRATION_GUIDE.md) | Hardware setup & Arduino coding |
| [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) | Project overview & features |
| [IMPLEMENTATION_CHECKLIST.md](IMPLEMENTATION_CHECKLIST.md) | Checklist untuk development progress |
| [POSTMAN_COLLECTION.json](POSTMAN_COLLECTION.json) | Postman collection untuk testing |

---

## 🏗️ Architecture

### System Overview
```
┌─────────────┐
│  Frontend   │  React/Vue Dashboard
│  (Browser)  │  - Login/Register
└──────┬──────┘  - Device Management
       │         - Real-time Dashboard
       │ HTTPS/HTTP
       ↓
┌──────────────────────┐
│    Backend API       │  Laravel 11 REST API
│    (Laravel)         │  - Authentication
└─────────┬────────────┘  - Device Management
          │               - Sensor Data Storage
          │               - Analytics
          ↓
┌──────────────────────┐
│    Database          │  MySQL
│    (MySQL)           │  - Users
└─────────┬────────────┘  - Devices
          │               - Sensor Data
          ↑
       HTTP ← WiFi
          ↑
┌──────────────────────┐
│  Hardware/IoT        │  ESP8266 D1 R2 Mini
│  (Sensors)           │  - DHT22 (Temp/Humidity)
└──────────────────────┘  - Soil Moisture
                         - Fan Control
                         - Pump Control
```

### Data Flow
```
ESP8266 (setiap 60 detik)
  ↓
  POST /api/sensor-data
  Authorization: Bearer {api_key}
  Body: { temperature, humidity, soil }
  ↓
  Validasi & Store di Database
  ↓
  Frontend fetch GET /api/devices/{id}/dashboard
  ↓
  Display real-time data & charts
```

---

## 📊 Database Schema

### Users Table
```
id | name | email | email_verified_at | password | remember_token | created_at | updated_at
```

### Devices Table
```
id | user_id | device_name | api_key | fan_threshold | soil_threshold | created_at | updated_at
```

### Sensor Data Table
```
id | device_id | temperature | humidity | soil | created_at | updated_at
```

---

## 🔐 Security

✅ Bearer token authentication (Sanctum)
✅ Unique API keys per device
✅ User authorization on all protected routes
✅ Input validation & sanitization
✅ CORS configuration ready
✅ Error handling dengan proper HTTP status codes
✅ No sensitive data in responses
✅ Rate limiting ready (optional)

---

## 📱 API Endpoints

### Authentication
```
POST   /api/register                 - Register user
POST   /api/login                    - Login user
GET    /api/me                       - Get current user
POST   /api/logout                   - Logout user
```

### Devices
```
GET    /api/devices                  - List user devices
POST   /api/devices                  - Create device
GET    /api/devices/{id}             - Get device details
PUT    /api/devices/{id}             - Update device
DELETE /api/devices/{id}             - Delete device
GET    /api/devices/{id}/code        - Get ESP8266 code
```

### Sensor Data
```
POST   /api/sensor-data              - Receive data from ESP8266
GET    /api/devices/{id}/sensor-latest      - Latest reading
GET    /api/devices/{id}/sensor-data        - History with filters
GET    /api/devices/{id}/dashboard   - Dashboard data (7-day)
```

Full documentation: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 📈 Control Logic

### Fan Control (Temperature)
```javascript
if (temperature > fan_threshold) {
  turnOnFan();
} else if (temperature < fan_threshold - 2) {
  turnOffFan();
}
```

### Pump Control (Soil Moisture)
```javascript
if (soil_moisture < soil_threshold) {
  turnOnPump();
} else if (soil_moisture > soil_threshold + 10) {
  turnOffPump();
}
```

Hysteresis built-in untuk mencegah rapid switching.

---

## 🧪 Testing

### API Testing
```bash
# Semua endpoints bisa ditest dengan:
1. Import POSTMAN_COLLECTION.json ke Postman
2. Atau gunakan cURL commands di documentation
```

### Database Testing
```bash
php artisan tinker
Device::with('sensorData')->get()
SensorData::latest()->first()
```

---

## 🔄 Project Status

| Component | Status | Progress |
|-----------|--------|----------|
| Backend API | ✅ Complete | 100% |
| Database Schema | ✅ Complete | 100% |
| Authentication | ✅ Complete | 100% |
| Device Management | ✅ Complete | 100% |
| Sensor Data Collection | ✅ Complete | 100% |
| Analytics & Dashboard | ✅ Complete | 100% |
| Documentation | ✅ Complete | 100% |
| Frontend UI | 🔄 In Progress | 0% |
| Hardware Integration | 📋 Planning | 0% |

---

## 📂 Project Structure

```
tugas-akhir/
├── app/
│   ├── Http/
│   │   └── Controllers/Api/
│   │       ├── AuthController.php
│   │       ├── DeviceController.php
│   │       └── SensorController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Device.php
│   │   └── SensorData.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   └── DatabaseSeeder.php
│   └── factories/
├── routes/
│   ├── api.php          (semua API routes)
│   └── web.php
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── Documentation/
│   ├── README.md
│   ├── API_DOCUMENTATION.md
│   ├── BACKEND_SETUP.md
│   ├── FRONTEND_INTEGRATION_GUIDE.md
│   ├── ESP8266_INTEGRATION_GUIDE.md
│   ├── PROJECT_SUMMARY.md
│   ├── IMPLEMENTATION_CHECKLIST.md
│   └── POSTMAN_COLLECTION.json
└── config/
```

---

## 🎯 Next Steps

### Untuk Frontend Developer
1. Read [FRONTEND_INTEGRATION_GUIDE.md](FRONTEND_INTEGRATION_GUIDE.md)
2. Setup development environment
3. Import [POSTMAN_COLLECTION.json](POSTMAN_COLLECTION.json) ke Postman
4. Mulai build UI components

### Untuk Hardware Developer
1. Read [ESP8266_INTEGRATION_GUIDE.md](ESP8266_INTEGRATION_GUIDE.md)
2. Setup Arduino IDE
3. Connect hardware components
4. Get ESP8266 code dari API
5. Upload & test

### Untuk Backend Developer
1. Buat additional features sesuai kebutuhan
2. Optimize database queries
3. Add logging & monitoring
4. Setup deployment pipeline

---

## 🐛 Known Issues

Tidak ada known issues pada backend. Semua endpoints working properly.

---

## 🤝 Contributing

Contributions welcome! Silakan:

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📞 Support

- Untuk API questions: Lihat [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- Untuk setup issues: Lihat [BACKEND_SETUP.md](BACKEND_SETUP.md)
- Untuk hardware: Lihat [ESP8266_INTEGRATION_GUIDE.md](ESP8266_INTEGRATION_GUIDE.md)
- Untuk frontend: Lihat [FRONTEND_INTEGRATION_GUIDE.md](FRONTEND_INTEGRATION_GUIDE.md)

---

## 📄 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🙏 Acknowledgments

Built with ❤️ using:
- [Laravel Framework](https://laravel.com)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Arduino Framework](https://www.arduino.cc)
- [ESP8266 Community](https://github.com/esp8266/Arduino)

---

**Backend Development Status:** 100% Complete ✅  
**Ready for Frontend Integration** 🚀


