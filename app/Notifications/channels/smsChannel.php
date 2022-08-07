<?php

namespace App\Nofications\Channels;

use Illuminate\Notifications\Notification;

class smsChannel
{
    public function send($notifiable,Notification $notification)
    {
        
        $data = $notification->toEramSms($notifiable);

        
         try 
        {
            $message = $data['text'];
            $lineNumber = "30005088";
            $receptor = $data['phone'];
            $api = new \Ghasedak\GhasedakApi('838f4f85e6123184d3ed9d06b44a870f238626673d4d10e39a2b4d069fe8039b');
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(\Ghasedak\Exceptions\ApiException $e){
            echo $e->errorMessage();
        }
        catch(\Ghasedak\Exceptions\HttpException $e){
            echo $e->errorMessage();
        }
    }
}