<?php

namespace NotificationChannels\WidepaySms;

use Illuminate\Support\Arr;

class WidepaySmsMessage
{
    protected $recipient, $sender, $message;
    // Message structure here

    public function sender($sender)
    {
        $this->sender = $sender;
        return $this;
    }
    

    public function recipient($recipient)
    {
        $this->recipient = $recipient ;
        return $this;

    }

    public function message($message = '')
    {
        $this->message = $message ;
        return $this;

    }

    public function getRecipient()
    {
        return $this->recipient;

    }

    public function toArray()
    {
        return [
            "sender_id" => $this->sender ??  'WidepayCash',
            "message" => $this->message,
            "recipient" => $this->recipient,
            "apiKey" => config('broadcasting.connections.widepay_sms.id', null),
            "apiSecret" => config('broadcasting.connections.widepay_sms.key', null),
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
