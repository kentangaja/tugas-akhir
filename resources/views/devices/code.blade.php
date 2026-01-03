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

const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

const char* server = "{{ config('app.url') }}/api/iot/send";
const char* apiKey = "{{ $device->api_key }}";

void setup() {
  Serial.begin(9600);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClientSecure client;
    client.setInsecure();

    http.begin(client, server);
    http.addHeader("Content-Type", "application/json");

    StaticJsonDocument&lt;200&gt; doc;
    doc["api_key"] = apiKey;
    doc["temperature"] = 25.5;
    doc["humidity"] = 60;

    String payload;
    serializeJson(doc, payload);

    http.POST(payload);
    http.end();
  }

  delay(5000);
}
</pre>

</div>
@endsection
