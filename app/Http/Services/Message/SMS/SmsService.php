<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\SMS\MelliPayamakService;
use Illuminate\Support\Facades\Log;

class SmsService implements MessageInterface
{
    private $from;
    private $text;
    private $to;
    private $isFlash;
    
    public function fire()
    {
        try {
            if (!$this->validate()) {
                return false;
            }

            $melliPayamak = new MelliPayamakService();
            return $melliPayamak->sendSmsSoapClient($this->from, $this->to, $this->text, $this->isFlash);
        } catch (\Exception $ex) {
            Log::error('SMS Service Error: ' . $ex->getMessage());
            return false;
        }
    }

    private function validate()
    {
        if (empty($this->from)) {
            Log::error('SMS Validation Error: From number is empty');
            return false;
        }

        if (empty($this->to)) {
            Log::error('SMS Validation Error: To number is empty');
            return false;
        }

        if (empty($this->text)) {
            Log::error('SMS Validation Error: Message text is empty');
            return false;
        }

        return true;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = is_array($to) ? $to : [$to];
    }

    public function getIsFlash()
    {
        return $this->isFlash;
    }

    public function setIsFlash($isFlash)
    {
        $this->isFlash = (bool) $isFlash;
    }
}