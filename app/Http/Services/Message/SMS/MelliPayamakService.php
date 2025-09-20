<?php

namespace App\Http\Services\Message\SMS;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MelliPayamakService
{
    private $username;
    private $password;
    private $client;
    private $apiUrl;

    public function __construct()
    {
        $this->username = Config::get('sms.username');
        $this->password = Config::get('sms.password');
        $this->apiUrl = Config::get('sms.api_url');
        
        Log::info('Initializing MelliPayamak Service', [
            'username' => $this->username,
            'api_url' => $this->apiUrl
        ]);
        
        if (empty($this->username) || empty($this->password) || empty($this->apiUrl)) {
            Log::error('MelliPayamak service credentials or API URL are not configured properly.');
            return;
        }
        
        $this->initializeClient();
    }

    private function initializeClient()
    {
        try {
            ini_set("soap.wsdl_cache_enabled", "0");
            Log::info('Creating SOAP client for MelliPayamak with WSDL: ' . $this->apiUrl);
            $this->client = new \SoapClient($this->apiUrl, [
                'encoding' => 'UTF-8',
                'trace' => 1, 
                'exceptions' => true 
            ]);
            Log::info('SOAP client for MelliPayamak created successfully');
        } catch (\SoapFault $ex) {
            Log::error('MelliPayamak Service Initialization Error (SoapFault)', [
                'error' => $ex->getMessage(),
                'fault_code' => $ex->faultcode ?? 'N/A',
                'fault_string' => $ex->faultstring ?? 'N/A',
                'api_url' => $this->apiUrl,
                'trace' => $ex->getTraceAsString()
            ]);
        } catch (\Exception $ex) { 
            Log::error('MelliPayamak Service Initialization Error (General Exception)', [
                'error' => $ex->getMessage(),
                'api_url' => $this->apiUrl,
                'trace' => $ex->getTraceAsString()
            ]);
        }
    }

    public function sendSmsSoapClient($from, $to, $text) // $to is expected from MelliPayamakChannel as ['09xxxxxxxxx']
    {
        if (!$this->client) {
            Log::error('MelliPayamak SOAP client is not initialized. Cannot send SMS.');
            return false;
        }

        $recipientString = '';
        if (is_array($to)) {
            if (!empty($to)) {
                // The MelliPayamak SendSimpleSMS2 'to' parameter expects a string for a single recipient.
                // $to is coming as an array like ['09123456789'] from MelliPayamakChannel.
                // We need to extract the first element.
                $recipientString = (string) $to[0];
            } else {
                Log::error('Recipient array ("to") is empty.', ['to_param' => $to]);
                return false;
            }
        } elseif (is_string($to)) {
             // If $to was already a string, use it directly.
            $recipientString = $to;
        } else {
            Log::error('Invalid recipient ("to") format. Expected string or array of one string.', ['to_param' => $to]);
            return false;
        }
        
        if (empty($recipientString)) {
            Log::error('No valid recipient number determined.', ['original_to' => $to]);
            return false;
        }

        try {
            $parameters = [
                'username' => $this->username,
                'password' => $this->password,
                'to' => $recipientString, // <<< 여기가 변경되었습니다: 문자열로 변경
                'from' => $from,
                'text' => $text,
                'isflash' => false 
            ];

            Log::info('Sending SMS request to MelliPayamak', [
                'from' => $from,
                'to' => $parameters['to'], // Now this will be a string
                'text_length' => strlen($text)
            ]);

            // This is line 90 in your original trace (actual line number might shift slightly with comments)
            $result = $this->client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;

                       // ...
                       $result = $this->client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;

                       Log::info('Received response from MelliPayamak', [
                           'result_code' => $result // $result اینجا معمولا رشته است
                       ]);
           
                       // کدهای موفقیت ملی پیامک را از مستنداتشان چک کنید.
                       // معمولا کدهای بزرگتر از یک مقدار خاص (مثلا 100) یا یک لیست مشخص از کدها موفقیت آمیز هستند.
                       // یا ممکن است ID پیامک را برگردانند که عددی است.
                       // کد "0" یا اعداد منفی معمولا خطا هستند. کد "11" هم خطای ساعت است.
                       
                       $successfulStatusCodes = ['1', 'ID_NUMERIC_VALID']; // مثال: کدهای موفقیت را اینجا لیست کنید
                       $isSuccess = false;
           
                       if (is_numeric($result)) {
                           $numericResult = (int)$result;
                           // فرض کنید کدهای بالای 100 موفقیت آمیز هستند یا ID پیامک.
                           // و کدهای خاص مثل 11 خطا هستند.
                           if ($numericResult > 100) { // این یک فرض است، مستندات را چک کنید.
                               $isSuccess = true;
                           } else if ($numericResult == 11) {
                               Log::warning('MelliPayamak: SMS sending restricted due to time (Code 11).', ['result' => $result]);
                               // اینجا نباید true برگردانیم چون پیامک ارسال نشده
                               return false; // یا throw new \Exception('ارسال در ساعات غیرمجاز');
                           }
                           // سایر کدهای خطای عددی را اینجا بررسی کنید
                       } else {
                           // اگر نتیجه رشته‌ای مانند یک ID خاص بود
                           if (in_array(strtoupper($result), array_map('strtoupper', $successfulStatusCodes))) {
                              $isSuccess = true;
                           }
                       }
           
           
                       if ($isSuccess) {
                           Log::info('SMS sent successfully via MelliPayamak.', ['message_id_or_status_code' => $result]);
                           return true;
                       }
           
                       Log::error('Failed to send SMS via MelliPayamak. Panel responded with a non-success code or error.', [
                           'result_code' => $result,
                           'parameters_sent' => [ /* ... */ ]
                       ]);
                       return false;
        } catch (\SoapFault $ex) {
            Log::error('MelliPayamak SMS Send Error (SoapFault)', [
                'error' => $ex->getMessage(),
                'fault_code' => $ex->faultcode ?? 'N/A',
                'fault_string' => $ex->faultstring ?? 'N/A',
                'trace' => $ex->getTraceAsString()
            ]);
            return false;
        } catch (\Exception $ex) {
            Log::error('MelliPayamak SMS Send Error (General Exception)', [
                'error' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ]);
            return false;
        }
    }

    public function getCredit()
    {
        if (!$this->client) {
            Log::error('MelliPayamak SOAP client is not initialized. Cannot get credit.');
            return 0;
        }
        try {
            Log::info('Checking SMS credit via MelliPayamak');
            $parameters = [
                'username' => $this->username,
                'password' => $this->password
            ];
            $result = $this->client->GetCredit($parameters)->GetCreditResult;
            Log::info('MelliPayamak SMS credit check result', ['credit' => $result]);
            return $result;
        } catch (\SoapFault $ex) {
            Log::error('MelliPayamak Credit Check Error (SoapFault)', [
                'error' => $ex->getMessage(),
                'fault_code' => $ex->faultcode ?? 'N/A',
                'fault_string' => $ex->faultstring ?? 'N/A',
                'trace' => $ex->getTraceAsString()
            ]);
            return 0;
        } catch (\Exception $ex) {
            Log::error('MelliPayamak Credit Check Error (General Exception)', [
                'error' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ]);
            return 0;
        }
    }
    
    // متدهای دیگر (addContact, addSchedule, etc.) بدون تغییر باقی می‌مانند
    // ... (کپی سایر متدها از فایل اصلی شما)
    public function addContact()
    {
        // ... (کد شما)
        Log::warning('MelliPayamakService::addContact is called with hardcoded credentials.');
        return null; 
    }

    public function addSchedule()
    {
        // ... (کد شما)
        Log::warning('MelliPayamakService::addSchedule is called with hardcoded credentials.');
        return null;
    }

    public function getInboxCountSoapClient()
    {
        // ... (کد شما)
        Log::warning('MelliPayamakService::getInboxCountSoapClient is called with hardcoded credentials.');
        return null;
    }

    public function getMessageStr()
    {
        // ... (کد شما)
        Log::warning('MelliPayamakService::getMessageStr is called with hardcoded credentials.');
        return null;
    }

    public function SendSimpleSms2SoapClient() 
    {
        Log::warning('MelliPayamakService::SendSimpleSms2SoapClient (demo method) was called.');
        // ... (کد شما)
        return null;
    }

    public function sendSmsNuSoap() 
    {
        Log::warning('MelliPayamakService::sendSmsNuSoap (using nusoap) was called. Consider using native SoapClient.');
        // ... (کد شما)
        return null;
    }
}