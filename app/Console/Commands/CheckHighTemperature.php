<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use App\Mail\HighTemperatureNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckHighTemperature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:check-high-temperature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for high temperature conditions and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $devices = Device::where('is_active', true)->get();

        foreach ($devices as $device) {
            $this->checkDeviceTemperature($device);
        }

        $this->info('Temperature check completed successfully.');
    }

    /**
     * Check temperature for a specific device
     */
    private function checkDeviceTemperature(Device $device)
    {
        $threshold = $device->high_temp_threshold ?? 35;
        $durationMinutes = $device->high_temp_duration ?? 30;
        $since = Carbon::now()->subMinutes($durationMinutes);

        // Get the latest sensor data reading
        $latest = $device->sensorData()->latest()->first();

        if (!$latest) {
            return;
        }

        // Count how many readings exceed the threshold in the given duration
        $highTempCount = $device->sensorData()
            ->where('temperature', '>', $threshold)
            ->where('created_at', '>=', $since)
            ->count();

        // If high temperature condition is detected
        if ($highTempCount > 0) {
            // Check if notification was already sent recently (within the last hour)
            $lastNotification = $device->last_high_temp_notification;
            $shouldSendNotification = true;

            if ($lastNotification) {
                $hourAgo = Carbon::now()->subHour();
                if ($lastNotification->greaterThan($hourAgo)) {
                    // Notification was sent recently, skip
                    $shouldSendNotification = false;
                }
            }

            if ($shouldSendNotification && $device->user->email) {
                try {
                    Mail::to($device->user->email)->send(
                        new HighTemperatureNotification(
                            $device,
                            $latest->temperature,
                            $threshold,
                            $durationMinutes
                        )
                    );

                    // Update last notification time
                    $device->update(['last_high_temp_notification' => Carbon::now()]);

                    $this->info("Notification sent for device: {$device->device_name}");
                } catch (\Exception $e) {
                    $this->error("Failed to send notification for device {$device->device_name}: {$e->getMessage()}");
                }
            }
        }
    }
}
