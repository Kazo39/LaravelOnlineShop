<?php

namespace App\Notifications;

use App\Mail\OrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public  $user;
    public  $order;
    public  $total_price;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $user, $order, $total_price)
    {
        $this->user = $user;
        $this->order = $order;
        $this->total_price = $total_price;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return OrderMail
     */
    public function toMail($notifiable)
    {
        return (new OrderMail($this->user, $this->order, $this->total_price))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
