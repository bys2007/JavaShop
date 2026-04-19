<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Can add 'mail' later if SMTP is configured
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Pesanan Dikonfirmasi: ' . $this->order->order_number)
                    ->greeting('Halo ' . $notifiable->name . '!')
                    ->line('Pesanan Anda ' . $this->order->order_number . ' telah dikonfirmasi oleh admin dan kini sedang diproses.')
                    ->action('Lihat Detail', url('/akun/pesanan/' . $this->order->id))
                    ->line('Terima kasih telah berbelanja di JavaShop.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_confirmed',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'title' => 'Pesanan Diproses',
            'message' => 'Hore! Pesanan ' . $this->order->order_number . ' telah disetujui admin dan sedang disiapkan.',
            'url' => '/akun/pesanan/' . $this->order->id,
        ];
    }
}
