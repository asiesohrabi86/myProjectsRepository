<?php

return [
    'username' => env('SMS_USERNAME', '09113561287'),
    'password' => env('SMS_PASSWORD', '0NT!7'),
    'otp_from' => env('SMS_OTP_FROM', '50002710061287'),
    'api_url' => env('SMS_API_URL', 'http://api.payamak-panel.com/post/send.asmx?wsdl'),
    
    'ghasedak' => [
        'api_key' => env('GHASEDAK_API_KEY', ''),
        'line_number' => env('GHASEDAK_LINE_NUMBER', '30005088'),
    ],
    
    'default_channel' => env('SMS_DEFAULT_CHANNEL', 'mellipayamak'),
];





