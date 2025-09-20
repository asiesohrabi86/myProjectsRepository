<?php

namespace App\Notifications\Channels;

use App\Http\Services\Message\SMS\MelliPayamakService; // اطمینان از use صحیح
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MelliPayamakChannel
{
    public function send($notifiable, Notification $notification)
    {
        try {
            if (method_exists($notification, 'toMelliPayamak')) {
                $data = $notification->toMelliPayamak($notifiable);
                
                Log::info('MelliPayamakChannel: Data received from notification for MelliPayamak', [
                    'data_phone_type' => gettype($data['phone']),
                    'data_phone_value' => $data['phone'],
                    'notifiable_id' => $notifiable->id ?? 'N/A'
                ]);
                
                $smsService = new MelliPayamakService();
                
                // $data['phone'] از toMelliPayamak به عنوان یک رشته می‌آید.
                // MelliPayamakService در اصلاح قبلی طوری تنظیم شد که پارامتر دوم را به عنوان یک آرایه دریافت کند
                // و اولین عضو آن را به عنوان رشته استخراج کند.
                // پس اینجا باید $data['phone'] را داخل یک آرایه قرار دهیم.
                $recipientForService = [$data['phone']];

                $result = $smsService->sendSmsSoapClient(
                    config('sms.otp_from'),
                    $recipientForService, // <<< تغییر برای اطمینان از ارسال آرایه تک عضوی
                    $data['text']
                );
                
                if (!$result) {
                    Log::error('MelliPayamakChannel: Failed to send SMS via MelliPayamakService', [
                        'phone' => $data['phone'],
                        'text_length' => strlen($data['text'])
                    ]);
                    // Exception را پرتاب می‌کنیم تا job در صف به عنوان failed علامت‌گذاری شود
                    throw new \Exception('خطا در ارسال پیامک از طریق MelliPayamakChannel (سرویس نتیجه ناموفق برگرداند)');
                }
                
                Log::info('MelliPayamakChannel: SMS sent successfully via MelliPayamakService', [
                    'phone' => $data['phone']
                ]);
                
                return true;
            } else {
                Log::error('MelliPayamakChannel: Method toMelliPayamak does not exist in notification.', [
                    'notification_class' => get_class($notification)
                ]);
                throw new \Exception('متد toMelliPayamak در نوتیفیکیشن یافت نشد.');
            }
        } catch (\Exception $e) {
            Log::error('MelliPayamakChannel: Exception during send', [
                'error_message' => $e->getMessage(),
                'notifiable_id' => $notifiable->id ?? 'N/A',
                'notification_type' => get_class($notification),
                // 'trace' => $e->getTraceAsString() // اگر لازم شد این را برای جزئیات بیشتر از کامنت خارج کنید
            ]);
            // مهم: Exception را مجدداً پرتاب کنید تا job در صف به عنوان failed علامت‌گذاری شود.
            throw $e;
        }
    }
}