<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TravelRequest;


class TravelRequestStatusUpdated extends Notification
{
    use Queueable;

    protected $travelRequest; // Adiciona a propriedade para armazenar o TravelRequest

    /**
     * Create a new notification instance.
     *
     * @param TravelRequest $travelRequest
     */
    public function __construct(TravelRequest $travelRequest)
    {
        $this->travelRequest = $travelRequest; // Armazena a instância de TravelRequest
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
        return (new MailMessage)
            ->line('Seu pedido de viagem foi ' . $this->travelRequest->status . '.')
            ->action('Ver Pedido', url('/travel-requests/' . $this->travelRequest->id));
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
