<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Device;

class HighTemperatureNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Device $device;
    public float $currentTemp;
    public float $threshold;
    public int $durationMinutes;

    /**
     * Create a new message instance.
     */
    public function __construct(Device $device, float $currentTemp, float $threshold, int $durationMinutes)
    {
        $this->device = $device;
        $this->currentTemp = $currentTemp;
        $this->threshold = $threshold;
        $this->durationMinutes = $durationMinutes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan: Suhu Tinggi di Stasiun ' . $this->device->device_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.high-temperature-notification',
            with: [
                'device' => $this->device,
                'currentTemp' => $this->currentTemp,
                'threshold' => $this->threshold,
                'durationMinutes' => $this->durationMinutes,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
