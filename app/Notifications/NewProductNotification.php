<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $product;
    protected $user;

    public function __construct($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_product',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar_url,
            'user_type' => $this->user->type,
            'user_country' => $this->user->country->name_ar ?? 'غير معروف',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'product_image' => $this->product->images->first() ? asset('storage/' . $this->product->images->first()->image_path) : null,
            'message' => 'قام ' . ($this->user->type == 'factory' ? 'مصنع' : 'شركة') . ' بإضافة منتج جديد: ' . $this->product->name,
            'action_url' => route('admin.factories.products')
        ];
    }
}
