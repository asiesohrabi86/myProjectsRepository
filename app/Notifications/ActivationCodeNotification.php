<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\MelliPayamakChannel;
use App\Notifications\Channels\GhasedakChannel; // این باید به فایل و کلاس صحیح اشاره کند
use Illuminate\Support\Facades\Log;

class ActivationCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;
    protected $phone;
    protected $channelName; // نام متغیر را به channelName تغییر دادم تا با channel خود لاراول تداخل نکند

    /**
     * Create a new notification instance.
     *
     * @param string $code
     * @param string $phone
     * @param string $channelName The name of the channel to use ('mellipayamak' or 'ghasedak')
     * @return void
     */
    public function __construct($code, $phone, $channelName = 'mellipayamak')
    {
        $this->code = $code;
        $this->phone = $phone;
        $this->channelName = $channelName;
        // در صورت نیاز، می‌توانید بعد از چند دقیقه صف را حذف کنید تا پیامک‌های قدیمی ارسال نشوند
        // $this->delay(now()->addMinutes(2)); 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        Log::info('Determining SMS channel for ActivationCodeNotification', [
            'selected_channel_name' => $this->channelName,
            'recipient_phone' => $this->phone,
            'notifiable_id' => $notifiable->id ?? null
        ]);

        switch (strtolower($this->channelName)) {
            case 'ghasedak':
                return [GhasedakChannel::class];
            case 'mellipayamak':
            default: // اگر کانال نامعتبر بود یا مشخص نشده بود، از ملی‌پیامک استفاده کن
                if (strtolower($this->channelName) !== 'mellipayamak') {
                    Log::warning('Invalid SMS channel specified, defaulting to MelliPayamak.', [
                        'specified_channel' => $this->channelName
                    ]);
                }
                return [MelliPayamakChannel::class];
        }
    }

    /**
     * Get the MelliPayamak representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toMelliPayamak($notifiable)
    {
        $message = "کد فعال‌سازی شما: {$this->code}";
        Log::info('Preparing MelliPayamak message for ActivationCodeNotification', [
            'phone' => $this->phone,
            'code' => $this->code,
            'message_text' => $message
        ]);

        return [
            'phone' => $this->phone,
            'text' => $message
        ];
    }

    /**
     * Get the Ghasedak representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toGhasedak($notifiable)
    {
        $message = "کد فعال‌سازی شما: {$this->code}";
        Log::info('Preparing Ghasedak message for ActivationCodeNotification', [
            'phone' => $this->phone,
            'code' => $this->code,
            'message_text' => $message
        ]);

        return [
            'phone' => $this->phone,
            'text' => $message
        ];
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
            'code' => $this->code,
            'phone' => $this->phone,
            'channel' => $this->channelName // از channelName استفاده می‌کنیم
        ];
    }
}