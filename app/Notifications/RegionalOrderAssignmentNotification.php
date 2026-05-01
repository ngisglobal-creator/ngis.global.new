<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegionalOrderAssignmentNotification extends Notification
{
    use Queueable;

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
            'type' => 'regional_order_assignment',
            'order_id' => $this->order->id,
            'user_id' => $this->client->id,
            'user_name' => $this->client->name,
            'user_avatar' => $this->client->avatar_url,
            'user_country' => $this->client->country->name_ar ?? 'غير معروف',
            'product_id' => $this->order->product->id,
            'product_name' => $this->order->product->name,
            'product_image' => $this->order->product->images->first() ? asset('storage/' . $this->order->product->images->first()->image_path) : null,
            'message' => 'تم تعيين طلب جديد لمنطقتك الجغرافية: ' . $this->order->product->name,
            'action_url' => route('regional.details') // Or specific orders page once created
        ];
    }
}
