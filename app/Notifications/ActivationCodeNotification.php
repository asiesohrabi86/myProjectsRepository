<?php

namespace App\Notifications;

use App\Nofications\Channels\smsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivationCodeNotification extends Notification
{
    use Queueable;

    public $code;
    public $phonenumber;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code,$phonenumber)
    {
        $this->code = $code;
        $this->$phonenumber = $phonenumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [smsChannel::class];
    }


    public function toEramSms($notifiable)
    {
        return [
            'text' => "کد احراز هویت شما {$this->code} \n لاراول لرن",
            'phone'=>$this->phonenumber
        ];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

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
