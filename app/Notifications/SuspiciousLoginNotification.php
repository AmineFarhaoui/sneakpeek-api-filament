<?php

namespace App\Notifications;

use App\Library\Services\IpApiService;
use App\Models\LoginAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspiciousLoginNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected LoginAttempt $loginAttempt)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $ipApiService = new IpApiService();

        return (new MailMessage)->markdown('emails.suspicious_login', [
            'loginAttempt' => $this->loginAttempt,
            'location' => $ipApiService->getLocationDetails($this->loginAttempt->ip_address),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
