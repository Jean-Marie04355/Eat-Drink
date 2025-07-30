<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Restriction;

class RestrictionNotification extends Notification
{
    use Queueable;

    protected $restriction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Restriction $restriction)
    {
        $this->restriction = $restriction;
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
        $daysLeft = now()->diffInDays($this->restriction->end_date, false);
        $hoursLeft = now()->diffInHours($this->restriction->end_date, false);
        
        $timeMessage = '';
        if ($daysLeft > 0) {
            $timeMessage = "Votre compte sera réactivé dans {$daysLeft} jour(s).";
        } elseif ($hoursLeft > 0) {
            $timeMessage = "Votre compte sera réactivé dans {$hoursLeft} heure(s).";
        } else {
            $timeMessage = "Votre compte sera réactivé très prochainement.";
        }

        return (new MailMessage)
            ->subject('🔒 Restriction de compte - EatDrink')
            ->greeting('Bonjour ' . $notifiable->nom_entreprise)
            ->line('Votre compte entrepreneur a été temporairement restreint.')
            ->line('**Motif:** ' . $this->restriction->motif)
            ->line('**Type de restriction:** ' . ucfirst($this->restriction->type))
            ->line('**Date de fin:** ' . $this->restriction->end_date->format('d/m/Y à H:i'))
            ->line('**' . $timeMessage . '**')
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, contactez l\'administration.')
            ->salutation('Cordialement, l\'équipe EatDrink');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'restriction_id' => $this->restriction->id,
            'type' => $this->restriction->type,
            'end_date' => $this->restriction->end_date,
            'motif' => $this->restriction->motif,
        ];
    }
} 