<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredNotification extends Notification implements ShouldQueue
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
                    ->subject('Pesanan Telah Tiba: ' . $this->order->order_number)
                    ->greeting('Halo ' . $notifiable->name . '!')
                    ->line('Pesanan Anda ' . $this->order->order_number . ' telah sampai tujuan.')
                    ->line('Bantu kami menjadi lebih baik dengan meninggalkan ulasan produk.')
                    ->action('Berikan Ulasan', url('/akun/pesanan/' . $this->order->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_delivered',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'title' => 'Pesanan Selesai',
            'message' => 'Pesanan ' . $this->order->order_number . ' sudah terkirim. Jangan lupa tinggalkan ulasan ya!',
            'url' => '/akun/pesanan/' . $this->order->id,
        ];
    }
}
