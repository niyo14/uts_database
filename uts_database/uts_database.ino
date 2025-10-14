#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

#define DHTPIN 23        // Pin data DHT11 dihubungkan ke GPIO 23 (ubah sesuai dengan rangkaianmu)
#define DHTTYPE DHT11    // <-- Ganti sensor ke DHT11
DHT dht(DHTPIN, DHTTYPE);

// ====== WIFI CONFIGURATION ======
const char* ssid = "niyo";          // Nama WiFi kamu
const char* password = "1234niyo";  // Password WiFi kamu

// ====== SERVER CONFIGURATION ======
String serverName = "http://10.210.156.110:8080/lab_iot/insert_sensor.php";

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nTerhubung ke WiFi!");
  Serial.print("IP ESP32: ");
  Serial.println(WiFi.localIP());

  dht.begin();
}

void loop() {
  float suhu = dht.readTemperature();
  float kelembapan = dht.readHumidity();

  if (isnan(suhu) || isnan(kelembapan)) {
    Serial.println("⚠️ Gagal membaca sensor DHT11!");
    delay(2000);
    return;
  }

  Serial.print("🌡️ Suhu: ");
  Serial.print(suhu);
  Serial.print(" °C  |  💧 Kelembapan: ");
  Serial.print(kelembapan);
  Serial.println(" %");

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Data yang dikirim ke PHP
    String postData = "id_sensor=S01&suhu=" + String(suhu) + "&kelembapan=" + String(kelembapan);
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      Serial.println("✅ Data terkirim ke MySQL!");
      Serial.print("📶 HTTP Response code: ");
      Serial.println(httpResponseCode);
    } else {
      Serial.print("❌ Gagal kirim ke server! Kode error: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi terputus, mencoba menyambung kembali...");
    WiFi.begin(ssid, password);
  }

  delay(5000); // kirim data setiap 5 detik
}