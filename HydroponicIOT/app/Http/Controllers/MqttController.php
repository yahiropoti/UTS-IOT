<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\SensorData;

class MqttController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new MqttClient('broker.hivemq.com', 1883);
    }

    public function subscribe()
    {
        $settings = (new ConnectionSettings())->setUsername('username')->setPassword('password');
        $this->client->connect($settings);

        // Subscribe ke topik 'hydroponic/data'
        $this->client->subscribe('hydroponic/data', function (string $topic, string $message) {
            $data = json_decode($message, true);

            // Menyimpan data ke database
            SensorData::create([
                'temperature' => $data['suhu'],
                'humidity' => $data['kelembapan']
            ]);
        });

        // Menunggu pesan dari broker
        $this->client->loop();
    }
}
