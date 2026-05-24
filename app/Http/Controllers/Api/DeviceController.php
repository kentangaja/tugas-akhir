<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Get all devices for authenticated user
     */
    public function index(Request $request)
    {
        $devices = $request->user()->devices()->with(['sensorData' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $devices,
        ]);
    }

    /**
     * Get single device with latest sensor data
     */
    public function show($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);

        return response()->json([
            'success' => true,
            'data' => $device,
        ]);
    }

    /**
     * Create new device
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'fan_threshold' => 'sometimes|numeric|min:0|max:50',
            'soil_dry_threshold' => 'sometimes|integer|min:0|max:100',
            'soil_wet_threshold' => 'sometimes|integer|min:0|max:100',
        ]);

        $device = $request->user()->devices()->create([
            'device_name' => $validated['device_name'],
            'api_key' => 'key_' . Str::random(40),
            'fan_threshold' => $validated['fan_threshold'] ?? null,
            'soil_dry_threshold' => $validated['soil_dry_threshold'] ?? 70,
            'soil_wet_threshold' => $validated['soil_wet_threshold'] ?? 40,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device created successfully',
            'data' => $device,
        ], 201);
    }

    /**
     * Update device settings
     */
    public function update($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);

        $validated = $request->validate([
            'device_name' => 'sometimes|string|max:255',
            'fan_threshold' => 'sometimes|numeric|min:0|max:50',
            'soil_dry_threshold' => 'sometimes|integer|min:0|max:100',
            'soil_wet_threshold' => 'sometimes|integer|min:0|max:100',
        ]);

        $device->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'data' => $device,
        ]);
    }

    /**
     * Delete device
     */
    public function destroy($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);
        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device deleted successfully',
        ]);
    }

    /**
     * Get ESP8266 code template
     */
    public function getCode($deviceId, Request $request)
    {
        $device = $request->user()->devices()->findOrFail($deviceId);

        $code = $this->generateESPCode($device);

        return response()->json([
            'success' => true,
            'device_id' => $device->id,
            'api_key' => $device->api_key,
            'code' => $code,
        ]);
    }

    /**
     * Generate ESP8266 Arduino code
     */
    private function generateESPCode(Device $device)
    {
        $apiKey = $device->api_key;
        $fanThreshold = $device->fan_threshold;
        $soilThreshold = $device->soil_threshold;

        return <<<'CODE'
#include <ESP8266WiFi.h>
#include <DHT.h>
#include <ArduinoJson.h>

// WiFi Configuration
const char* ssid = "YOUR_SSID";
const char* password = "YOUR_PASSWORD";

// Server Configuration
const char* server = "your-server.com";
const int port = 80;
const char* apiKey = "{$apiKey}";

// Sensor Configuration
#define DHTPIN D4        // GPIO 2 (D4)
#define DHTTYPE DHT22    // DHT22 sensor
#define SOIL_PIN A0      // Analog pin for soil moisture
#define FAN_PIN D1       // GPIO 5 (D1) - Fan control
#define PUMP_PIN D2      // GPIO 4 (D2) - Pump control

DHT dht(DHTPIN, DHTTYPE);
WiFiClient client;

// Thresholds
float fanThreshold = {$fanThreshold};    // Temperature threshold for fan (°C)
int soilThreshold = {$soilThreshold};    // Soil moisture threshold (0-100%)

// Timing
unsigned long lastSendTime = 0;
const unsigned long sendInterval = 60000;  // Send every 60 seconds

void setup() {
  Serial.begin(115200);
  delay(100);

  // Initialize pins
  pinMode(FAN_PIN, OUTPUT);
  pinMode(PUMP_PIN, OUTPUT);
  digitalWrite(FAN_PIN, LOW);
  digitalWrite(PUMP_PIN, LOW);

  // Initialize sensor
  dht.begin();

  // Connect to WiFi
  connectToWiFi();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    connectToWiFi();
  }

  if (millis() - lastSendTime >= sendInterval) {
    readAndSendData();
    lastSendTime = millis();
  }

  delay(1000);
}

void connectToWiFi() {
  Serial.println("\n\nStarting WiFi connection...");
  WiFi.begin(ssid, password);

  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 20) {
    delay(500);
    Serial.print(".");
    attempts++;
  }

  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\nWiFi connected!");
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println("\nFailed to connect to WiFi");
  }
}

void readAndSendData() {
  // Read DHT22 sensor
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();

  // Read soil moisture (convert to percentage)
  int soilRaw = analogRead(SOIL_PIN);
  int soilMoisture = map(soilRaw, 1024, 0, 0, 100);

  // Check for sensor errors
  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  Serial.println("\n=== Sensor Data ===");
  Serial.print("Temperature: ");
  Serial.print(temperature);
  Serial.println("°C");
  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.println("%");
  Serial.print("Soil Moisture: ");
  Serial.print(soilMoisture);
  Serial.println("%");

  // Control devices
  controlDevices(temperature, soilMoisture);

  // Send data to server
  sendDataToServer(temperature, humidity, soilMoisture);
}

void controlDevices(float temperature, int soilMoisture) {
  // Fan control based on temperature
  if (temperature > fanThreshold) {
    digitalWrite(FAN_PIN, HIGH);
    Serial.println("Fan: ON");
  } else if (temperature < (fanThreshold - 2)) {
    digitalWrite(FAN_PIN, LOW);
    Serial.println("Fan: OFF");
  }

  // Pump control based on soil moisture
  if (soilMoisture < soilThreshold) {
    digitalWrite(PUMP_PIN, HIGH);
    Serial.println("Pump: ON");
  } else if (soilMoisture > (soilThreshold + 10)) {
    digitalWrite(PUMP_PIN, LOW);
    Serial.println("Pump: OFF");
  }
}

void sendDataToServer(float temperature, float humidity, int soilMoisture) {
  if (client.connect(server, port)) {
    // Create JSON payload
    StaticJsonDocument<200> doc;
    doc["temperature"] = temperature;
    doc["humidity"] = humidity;
    doc["soil"] = soilMoisture;

    String jsonData;
    serializeJson(doc, jsonData);

    // Send HTTP POST request
    client.println("POST /api/iot/sensor-data HTTP/1.1");
    client.print("Host: ");
    client.println(server);
    client.println("Content-Type: application/json");
    client.println("Connection: close");
    client.print("Authorization: Bearer ");
    client.println(apiKey);
    client.print("Content-Length: ");
    client.println(jsonData.length());
    client.println();
    client.println(jsonData);

    Serial.println("Data sent to server");

    // Read response
    while (client.connected()) {
      if (client.available()) {
        String line = client.readStringUntil('\r');
        Serial.println(line);
      }
    }
    client.stop();
  } else {
    Serial.println("Failed to connect to server");
  }
}
CODE;
    }
}
