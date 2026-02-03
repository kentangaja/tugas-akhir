<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Create test device
        $device = Device::create([
            'user_id' => $user->id,
            'device_name' => 'Living Room Sensor',
            'api_key' => 'key_' . Str::random(40),
            'fan_threshold' => 28.5,
            'soil_threshold' => 40,
        ]);

        // Create sample sensor data for the past 7 days
        $now = now();
        for ($i = 0; $i < 168; $i++) { // 7 days * 24 hours = 168 hours
            SensorData::create([
                'device_id' => $device->id,
                'temperature' => rand(20, 30) + rand(0, 10) / 10,
                'humidity' => rand(40, 80) + rand(0, 10) / 10,
                'soil' => rand(20, 70),
                'created_at' => $now->subHours($i),
                'updated_at' => $now->subHours($i),
            ]);
        }
    }
}
