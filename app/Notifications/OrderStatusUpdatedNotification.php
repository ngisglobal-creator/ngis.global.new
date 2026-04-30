<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;
    protected $seller;

    public function __construct($order, $seller)
    {
        $this->order = $order;
        $this->seller = $seller;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statusText = $this->order->status == 'accepted' ? 'بالموافقة على' : 'برفض';
        return [
            'type' => 'order_status_updated',
            'order_id' => $this->order->id,
            'user_id' => $this->seller->id,
            'user_name' => $this->seller->name,
            'user_avatar' => $this->seller->avatar_url,
            'user_country' => $this->seller->country->name_ar ?? 'غير معروف',
            'product_id' => $this->order->product->id,
            'product_name' => $this->order->product->name,
            'product_image' => $this->order->product->images->first() ? asset('storage/' . $this->order->product->images->first()->image_path) : null,
            'message' => 'قام البائع ' . $statusText . ' طلبك للمنتج: ' . $this->order->product->name,
            'status' => $this->order->status,
            'action_url' => route('client.orders.index')
        ];
    }
}
