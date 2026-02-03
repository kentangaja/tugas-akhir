@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ESP8266 Source Code</h2>
    <p>Copy & paste this code into Arduino IDE</p>

<pre style="background:#111;color:#0f0;padding:15px;">
#include &lt;ESP8266WiFi.h&gt;
#include &lt;ESP8266HTTPClient.h&gt;
#include &lt;ArduinoJson.h&gt;
#include &lt;DHT.h&gt;

#define DHTPIN D4     
#define DHTTYPE DHT11 
#define SOIL_PIN A0   

DHT dht(DHTPIN, DHTTYPE);

// ======================== KONFIGURASI LOKAL ========================
const char* ssid = "NAMA_WIFI_ANDA";         
const char* password = "PASSWORD_WIFI_ANDA"; 
const char* serverIP = "192.168.1.15"; 
const int serverPort = 8000;
const char* serverPath = "/api/sensor-data";
const char* apiKey = "API_KEY_DARI_LARAVEL"; 
// ===================================================================

const int SEND_INTERVAL = 5000;
int failCount = 0;

void setup() {
  Serial.begin(115200);
  delay(100);
  dht.begin();
  
  Serial.println("\n\n========================================");
  Serial.println("=== ESP8266 -> Laravel Sensor Data ===");
  Serial.println("========================================");
  Serial.print("API Key: ");
  Serial.println(String(apiKey).substring(0, 10) + "...");
  Serial.println("");
  
  connectToWiFi();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("⚠️  WiFi terputus, mencoba reconnect...");
    connectToWiFi();
  }

  // Baca sensor
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  int soilMoisture = analogRead(SOIL_PIN);

  // Validasi sensor DHT
  if (isnan(temperature)) {
    Serial.println("❌ ERROR SENSOR DHT: Temperature tidak terbaca!");
    Serial.println("   → Periksa kabel DHT11 ke pin D4");
    Serial.println("   → Pastikan DHT sudah 'dht.begin()' di setup");
    delay(2000);
    return;
  }

  if (isnan(humidity)) {
    Serial.println("❌ ERROR SENSOR DHT: Humidity tidak terbaca!");
    Serial.println("   → Periksa koneksi DHT11");
    delay(2000);
    return;
  }

  // Validasi sensor tanah
  if (soilMoisture &lt; 0 || soilMoisture &gt; 1023) {
    Serial.println("❌ ERROR SENSOR TANAH: Nilai analog tidak valid!");
    Serial.print("   → Nilai terbaca: ");
    Serial.println(soilMoisture);
    delay(2000);
    return;
  }

  sendDataToServer(temperature, humidity, soilMoisture);
  delay(SEND_INTERVAL);
}

void connectToWiFi() {
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  delay(100);
  WiFi.begin(ssid, password);
  
  Serial.print("📡 Menghubungkan ke WiFi: ");
  Serial.println(ssid);
  
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED &amp;&amp; attempts &lt; 20) {
    delay(500);
    Serial.print(".");
    attempts++;
  }
  
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\n✅ WiFi Terhubung!");
    Serial.print("   IP ESP8266: ");
    Serial.println(WiFi.localIP());
    Serial.println("");
    failCount = 0;
  } else {
    Serial.println("\n❌ ERROR WIFI: Tidak bisa terhubung ke WiFi!");
    Serial.println("   → Periksa nama WiFi (ssid)");
    Serial.println("   → Periksa password WiFi");
    Serial.println("   → Pastikan WiFi dalam jangkauan");
    Serial.print("   → Status: ");
    Serial.println(WiFi.status());
  }
}

void sendDataToServer(float temp, float humidity, int soil) {
  WiFiClient client;
  HTTPClient http;
  
  String url = "http://" + String(serverIP) + ":" + String(serverPort) + serverPath;
  
  Serial.println("--- MENGIRIM DATA SENSOR ---");
  Serial.print("URL: ");
  Serial.println(url);

  // Setup HTTP
  if (!http.begin(client, url)) {
    Serial.println("❌ ERROR KONEKSI HTTP: Gagal setup URL!");
    Serial.println("   → Periksa serverIP: " + String(serverIP));
    Serial.println("   → Periksa serverPort: " + String(serverPort));
    return;
  }

  http.addHeader("Content-Type", "application/json");
  
  // Bearer Token
  String authHeader = "Bearer " + String(apiKey);
  http.addHeader("Authorization", authHeader);

  // Siapkan JSON
  StaticJsonDocument&lt;200&gt; doc;
  doc["temperature"] = temp;    
  doc["humidity"] = humidity;    
  doc["soil"] = soil;            

  String payload;
  serializeJson(doc, payload);

  Serial.println("📤 Payload: " + payload);
  
  // Kirim POST request
  int httpCode = http.POST(payload);

  Serial.print("📨 HTTP Response Code: ");
  Serial.println(httpCode);

  if (httpCode &gt; 0) {
    String response = http.getString();
    
    if (httpCode == 200 || httpCode == 201) {
      Serial.println("✅ SUKSES! Data tersimpan di database");
      Serial.println("   Respon: " + response);
      failCount = 0;
    } 
    else if (httpCode == 401) {
      Serial.println("❌ ERROR AUTH (401): API Key tidak valid!");
      Serial.println("   → Copy API Key yang benar dari Laravel");
      Serial.println("   → Pastikan format: const char* apiKey = \"...\";");
      Serial.println("   → Respon: " + response);
      failCount++;
    }
    else if (httpCode == 422) {
      Serial.println("❌ ERROR VALIDASI (422): Data tidak sesuai format!");
      Serial.println("   → Pastikan ada field: temperature, humidity, soil");
      Serial.println("   → Respon: " + response);
      failCount++;
    }
    else if (httpCode == 500) {
      Serial.println("❌ ERROR SERVER (500): Error di Laravel!");
      Serial.println("   → Cek logs Laravel: php artisan log:tail");
      Serial.println("   → Respon: " + response);
      failCount++;
    }
    else {
      Serial.print("⚠️  Status tidak terduga (");
      Serial.print(httpCode);
      Serial.println(")");
      Serial.println("   Respon: " + response);
      failCount++;
    }
  } 
  else {
    String errorMsg = http.errorToString(httpCode);
    
    Serial.print("❌ ERROR KONEKSI (");
    Serial.print(httpCode);
    Serial.println("): " + errorMsg);
    
    if (httpCode == HTTPC_ERROR_CONNECTION_REFUSED) {
      Serial.println("   → Laravel server tidak running");
      Serial.println("   → Jalankan: php artisan serve --host=0.0.0.0");
    }
    else if (httpCode == HTTPC_ERROR_SEND_HEADER_FAILED) {
      Serial.println("   → Gagal mengirim header");
      Serial.println("   → Periksa WiFi connection");
    }
    else if (httpCode == HTTPC_ERROR_SEND_PAYLOAD_FAILED) {
      Serial.println("   → Gagal mengirim data");
      Serial.println("   → Periksa koneksi internet");
    }
    else if (httpCode == HTTPC_ERROR_NOT_CONNECTED) {
      Serial.println("   → Tidak terhubung ke server");
      Serial.println("   → Periksa IP dan Port server");
    }
    
    failCount++;
  }

  // Summary
  Serial.print("📊 Total gagal: ");
  Serial.print(failCount);
  Serial.println(" kali");
  Serial.println("");

  http.end();
}
</pre>

</div>
@endsection
