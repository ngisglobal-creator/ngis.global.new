<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;
    protected $client;

    public function __construct($order, $client)
    {
        $this->order = $order;
        $this->client = $client;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_order',
            'order_id' => $this->order->id,
            'user_id' => $this->client->id,
            'user_name' => $this->client->name,
            'user_avatar' => $this->client->avatar_url,
            'user_country' => $this->client->country->name_ar ?? 'غير معروف',
            'product_id' => $this->order->product->id,
            'product_name' => $this->order->product->name,
            'product_image' => $this->order->product->images->first() ? asset('storage/' . $this->order->product->images->first()->image_path) : null,
            'message' => 'لديك طلب جديد على منتج: ' . $this->order->product->name,
            'action_url' => $notifiable->type == 'admin' ? route('admin.clients.orders') : route('orders.received.show', $this->order->id)
        ];
    }
}
