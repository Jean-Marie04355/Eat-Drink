<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DemandeApprouveeNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre demande a été approuvée !')
            ->greeting('Bonjour ' . $notifiable->nom_entreprise . ',')
            ->line('Félicitations ! Votre demande de stand sur Eat&Drink a été approuvée.')
            ->line('Vous pouvez maintenant accéder à votre espace exposant et ajouter vos produits.')
            ->action('Accéder à mon espace', url('/login'))
            ->line('Merci d\'utiliser Eat&Drink !');
    }
}
