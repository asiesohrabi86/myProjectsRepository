<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
// اگر از پکیج رسمی قاصدک استفاده می‌کنید، use مربوط به GhasedakApi را اضافه کنید
// use Ghasedak\GhasedakApi; // برای مثال

class GhasedakChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toGhasedak')) {
            Log::error('Method toGhasedak does not exist in notification class.', [
                'notification' => get_class($notification)
            ]);
            return;
        }

        $data = $notification->toGhasedak($notifiable);

        $apiKey = Config::get('sms.ghasedak.api_key');
        $lineNumber = Config::get('sms.ghasedak.line_number');
        
        if (empty($apiKey)) {
            Log::error('Ghasedak API key is not configured in sms.php config or .env file.');
            return;
        }
        if (empty($lineNumber)) {
            Log::warning('Ghasedak line number is not configured. Default might be used by the provider.');
            // برخی پنل‌ها ممکن است بدون شماره خط هم کار کنند یا شماره پیشفرض داشته باشند
        }

        $receptor = $data['phone'];
        $message = $data['text'];

        Log::info('Preparing to send SMS via GhasedakChannel', [
            'receptor' => $receptor,
            'message_length' => strlen($message),
            'line_number' => $lineNumber,
            // 'api_key_present' => !empty($apiKey) // برای امنیت، خود کلید را لاگ نمی‌کنیم
        ]);

        try {
            // اطمینان حاصل کنید که کلاس GhasedakApi به درستی لود شده باشد (از طریق composer autoload یا use در بالای فایل)
            // اگر پکیج رسمی را نصب کرده‌اید: composer require ghasedak/ghasedak-php
            if (!class_exists(\Ghasedak\GhasedakApi::class)) {
                Log::error('GhasedakApi class not found. Please ensure the Ghasedak PHP SDK is installed and autoloaded.');
                return;
            }
            
            $api = new \Ghasedak\GhasedakApi($apiKey);
            // متد ارسال در پکیج قاصدک ممکن است SendSimple یا Send یا چیز دیگری باشد.
            // با توجه به کد شما، SendSimple استفاده شده.
            $response = $api->SendSimple($receptor, $message, $lineNumber); 

            // لاگ کردن پاسخ از قاصدک
            // پاسخ موفقیت آمیز از قاصدک معمولا شامل اطلاعاتی مانند messageid است.
            // در صورت خطا، Exception پرتاب می‌شود.
            Log::info('SMS sent successfully via GhasedakChannel.', [
                'receptor' => $receptor,
                'response_items' => $response // (اگر $response آرایه‌ای از آیتم‌هاست) یا خود $response
            ]);

        } catch (\Ghasedak\Exceptions\ApiException $e) {
            Log::error('Ghasedak API Exception occurred.', [
                'receptor' => $receptor,
                'error_message' => $e->errorMessage(),
                // 'error_code' => method_exists($e, 'getCode') ? $e->getCode() : 'N/A',
                'trace' => $e->getTraceAsString()
            ]);
        } catch (\Ghasedak\Exceptions\HttpException $e) {
            Log::error('Ghasedak HTTP Exception occurred.', [
                'receptor' => $receptor,
                'error_message' => $e->errorMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        } catch (\Exception $e) {
            Log::error('General Exception occurred while sending SMS via GhasedakChannel.', [
                'receptor' => $receptor,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}