<?php

namespace NotificationChannels\WidepaySms;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use Illuminate\Support\Facades\Http;

class WidepaySmsChannel
{
    const DEFAULT_SMS_URL = 'https://api.widepaycash.com/v1.1/sms/send-quick';

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
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

            Http::post(static::DEFAULT_SMS_URL, $message->toArray())->throw();

        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException);
        }

    }
}
