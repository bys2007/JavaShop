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

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Pesanan Sedang Dikirim: ' . $this->order->order_number)
                    ->greeting('Halo ' . $notifiable->name . '!')
                    ->line('Pesanan Anda ' . $this->order->order_number . ' telah dikirimkan oleh kurir kami.')
                    ->line('Nomor Resi: ' . ($this->order->tracking_number ?? 'Akan diupdate kurir'))
                    ->action('Lacak Pesanan', url('/akun/pesanan/' . $this->order->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_shipped',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'title' => 'Pesanan Dikirim',
            'message' => 'Paket Anda (Resi: ' . ($this->order->tracking_number ?? '-') . ') sudah meluncur ke tujuan!',
            'url' => '/akun/pesanan/' . $this->order->id,
        ];
    }
}
