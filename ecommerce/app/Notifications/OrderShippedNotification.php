<?php
namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    public function via(object $notifiable): array { return ['mail', 'database']; }

    public function toMail(object $notifiable): MailMessage
    {
        $tracking = $this->order->shipment?->tracking_number ?? 'N/A';
        return (new MailMessage)
            ->subject("Your Order Has Been Shipped!")
            ->line("Order #{$this->order->order_number} has been shipped.")
            ->line("Tracking Number: {$tracking}")
            ->action('Track Order', url("/orders/{$this->order->id}"));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message'  => "Order #{$this->order->order_number} has been shipped.",
        ];
    }
}
