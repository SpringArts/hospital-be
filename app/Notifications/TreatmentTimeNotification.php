<?php

namespace App\Notifications;

use App\Models\TreatmentTime;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function Symfony\Component\Translation\t;

class TreatmentTimeNotification extends Notification
{
    use Queueable;

    public $user ;
    public $treatment;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $user ,$treatmentTime)
    {
        $this->user = $user;
        $this->treatment = $treatmentTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail' , 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('New Treatment Time is created')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user' => $this->user,
            'treatment' => $this->treatment
        ];
    }
}
