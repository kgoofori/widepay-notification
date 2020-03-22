<?php

namespace NotificationChannels\WidepaySms;

use Illuminate\Notifications\Notification;
use App\Channels\Exceptions\CouldNotSendNotification;

class WidepaySmsChannel
{
    const DEFAULT_SMS_URL = 'https://api.widepaycash.com/v1.1/sms/send-quick';

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \Kgoofori\WidepaySms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the message from the notification class
        if (! $notifiable->routeNotificationFor('widepay-sms')) {
            throw CouldNotSendNotification::serviceRespondedWithAnError('Route notification not found.');
        }

        $message = $notification->toWidepaySms($notifiable);

        if (empty($message)) {
            throw CouldNotSendNotification::serviceRespondedWithAnError('toWidepaySms is not well implemeted');
        }

        if(empty($message->getRecipient())){
            $message->recipient($notifiable->routeNotificationForWidepaySms());
        }

        try {
            (new \GuzzleHttp\Client())
                ->request('POST', static::DEFAULT_SMS_URL, [
                    'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json',],
                    'body' => $message->toJson(),
                    'verify' => false,
                ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException);
        }

    }
}
