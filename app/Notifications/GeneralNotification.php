<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['database']; // ما نوتیفیکیشن را در دیتابیس ذخیره می‌کنیم
    }

    public function toArray($notifiable): array
    {
        return $this->data; // داده‌هایی که در ستون `data` جدول notifications ذخیره می‌شود
    }
}