<x-app-layout>
    <div class="min-h-screen bg-white py-12 px-6">
        <div class="max-w-4xl mx-auto">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <a href="{{ route('devices.index') }}" class="text-sm text-gray-400 hover:text-emerald-600 transition-colors">
                        ← Back to Dashboard
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">ESP8266 Source Code</h2>
                    <p class="text-gray-500 text-sm mt-1">Configure your device with the sketch below</p>
                </div>

                <button onclick="copyToClipboard()" id="copyBtn" 
                    class="flex items-center gap-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-5 py-2.5 rounded-2xl text-sm font-bold transition-all border border-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                    <span>Copy Code</span>
                </button>
            </div>

            <div class="relative group">
                <div class="bg-zinc-900 rounded-t-[2rem] px-6 py-4 flex items-center gap-2 border-b border-zinc-800">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                    </div>
                    <span class="ml-4 text-xs font-mono text-zinc-500">verte_maison_esp8266.ino</span>
                </div>

                <div class="bg-zinc-950 rounded-b-[2rem] p-6 md:p-8 overflow-hidden shadow-2xl border-x border-b border-zinc-900">
                    <div class="overflow-x-auto custom-scrollbar">
                        <pre id="codeBlock" class="text-sm md:text-base font-mono leading-relaxed text-zinc-300"><code>#include &lt;ESP8266WiFi.h&gt;
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
const char* serverIP = "{{ request()->getHost() }}"; 
const int serverPort = 8000;
const char* serverPath = "/api/sensor-data";
const char* apiKey = "{{ $device->api_key ?? 'API_KEY_ANDA' }}"; 
// ===================================================================

const int SEND_INTERVAL = 5000;

void setup() {
  Serial.begin(115200);
  dht.begin();
  connectToWiFi();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) connectToWiFi();

  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  int soilMoisture = analogRead(SOIL_PIN);

  if (!isnan(temperature) && !isnan(humidity)) {
    sendDataToServer(temperature, humidity, soilMoisture);
  }
  delay(SEND_INTERVAL);
}

void connectToWiFi() {
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\n✅ Connected!");
}

void sendDataToServer(float temp, float hum, int soil) {
  WiFiClient client;
  HTTPClient http;
  String url = "http://" + String(serverIP) + ":" + String(serverPort) + serverPath;

  if (http.begin(client, url)) {
    http.addHeader("Content-Type", "application/json");
    http.addHeader("Authorization", "Bearer " + String(apiKey));

    StaticJsonDocument&lt;200&gt; doc;
    doc["temperature"] = temp;
    doc["humidity"] = hum;
    doc["soil"] = soil;

    String payload;
    serializeJson(doc, payload);
    int httpCode = http.POST(payload);
    http.end();
  }
}</code></pre>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100">
                    <span class="text-emerald-600 font-bold text-xl">01</span>
                    <h4 class="font-bold text-gray-800 mt-2">Libraries</h4>
                    <p class="text-xs text-gray-500 mt-1">Install DHT sensor, ArduinoJson, and ESP8266 boards via Library Manager.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100">
                    <span class="text-emerald-600 font-bold text-xl">02</span>
                    <h4 class="font-bold text-gray-800 mt-2">Wiring</h4>
                    <p class="text-xs text-gray-500 mt-1">Connect DHT11 to Pin D4 and Soil Moisture to Pin A0 on your NodeMCU.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100">
                    <span class="text-emerald-600 font-bold text-xl">03</span>
                    <h4 class="font-bold text-gray-800 mt-2">Server Host</h4>
                    <p class="text-xs text-gray-500 mt-1">Ensure your laptop and ESP8266 are on the same WiFi network.</p>
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #09090b;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }
    </style>

    <script>
        function copyToClipboard() {
            const code = document.getElementById('codeBlock').innerText;
            const btn = document.getElementById('copyBtn');
            const originalText = btn.innerHTML;

            navigator.clipboard.writeText(code).then(() => {
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    <span class="text-emerald-500">Copied!</span>
                `;
                btn.classList.add('bg-emerald-100');

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('bg-emerald-100');
                }, 2000);
            });
        }
    </script>
</x-app-layout>