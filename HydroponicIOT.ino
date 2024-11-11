#include <DHT.h>
#include <WiFi.h>
#include <HTTPClient.h>

// Definisi PIN
#define DHT_PIN 8
#define LED_GREEN_PIN 5
#define LED_YELLOW_PIN 10
#define LED_RED_PIN 12
#define RELAY_PIN 7
#define BUZZER_PIN 9

// Definisi Sensor DHT
#define DHT_TYPE DHT11
DHT dht(DHT_PIN, DHT_TYPE);

// Koneksi WiFi
const char* ssid = "Blueberry";
const char* password = "22222222";

// Inisialisasi koneksi WiFi
void setup_wifi() {
  delay(100);
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi connected");
}

// Fungsi untuk mengirim data ke Laravel API
void sendDataToLaravel(float suhu, float kelembapan) {
    HTTPClient http;
    String url = "http://localhost/api/sensor-data"; // Ganti dengan URL API Laravel kamu

    // Siapkan data untuk dikirim
    String payload = "{\"suhu\": " + String(suhu) + ", \"kelembapan\": " + String(kelembapan) + "}";

    http.begin(url);
    http.addHeader("Content-Type", "application/json");

    // Kirim data dengan POST request
    int httpCode = http.POST(payload);

    if (httpCode > 0) {
        Serial.println("Data sent successfully!");
    } else {
        Serial.println("Error sending data.");
    }

    http.end(); // Akhiri HTTP request
}

void setup() {
    setup_wifi(); // Koneksi ke WiFi
    dht.begin();  // Inisialisasi sensor DHT

    // Setting pin mode untuk LED, Relay, dan Buzzer
    pinMode(LED_GREEN_PIN, OUTPUT);
    pinMode(LED_YELLOW_PIN, OUTPUT);
    pinMode(LED_RED_PIN, OUTPUT);
    pinMode(RELAY_PIN, OUTPUT);
    pinMode(BUZZER_PIN, OUTPUT);
}

void loop() {
    // Baca data dari sensor DHT
    float suhu = dht.readTemperature();
    float kelembapan = dht.readHumidity();

    // Kirim data ke API Laravel
    sendDataToLaravel(suhu, kelembapan);

    // Kondisi kontrol berdasarkan suhu dan kelembapan
    if (suhu > 30) {
        digitalWrite(LED_RED_PIN, HIGH);
        digitalWrite(LED_GREEN_PIN, LOW);
        digitalWrite(RELAY_PIN, HIGH); // Menyalakan pompa
    } else {
        digitalWrite(LED_GREEN_PIN, HIGH);
        digitalWrite(LED_RED_PIN, LOW);
        digitalWrite(RELAY_PIN, LOW); // Mematikan pompa
    }

    delay(2000); // Delay 2 detik sebelum membaca data lagi
}
