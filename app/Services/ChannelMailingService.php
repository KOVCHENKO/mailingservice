<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 3:39 PM
 */

namespace App\Services;


use App\Models\ChannelType\EmailChannel;
use App\Models\ChannelType\SmsChannel;
use App\Models\ChannelType\TelegramChannel;
use App\Models\Message;

class ChannelMailingService
{
    private $channelsArray = array();
    private $statusService;
    private $message;
    
    /**
     * ChannelMailingService constructor.
     */
    public function __construct(
        StatusService $statusService, Message $message,
        SmsChannel $smsChannel, EmailChannel $emailChannel, TelegramChannel $telegramChannel)
    {
        $this->statusService = $statusService;
        $this->message = $message;

        array_push($this->channelsArray, $smsChannel, $emailChannel, $telegramChannel);
    }

    /**
     * @param $channelsArray
     * @param $messageId
     * @param $contactData
     * Отправка по разным каналам
     */
    public function sendToDifferentChannels($channelsArray, $contactData, $messageId)
    {
        $attemptResult = false;

        foreach ($this->channelsArray as $singleChannel)
        {
            if(in_array($singleChannel->type, $channelsArray))
            {
                $status = $singleChannel->send($contactData);

                if($status) {
                    $attemptResult = $this->statusService->saveStatusSend($singleChannel, $messageId);
                } else {
                    $attemptResult = $this->statusService->saveStatusFailed($singleChannel, $messageId);
                }
            }
        }

        return $attemptResult;
    }

    /**
     * @param $messageId
     * @param $channels
     * Проверить статус сообщения
     */
    public function getMessageStatus($message)
    {
        foreach ($message->channels as $channel)
        {
            foreach ($this->channelsArray as $singleChannelType)
            {
                if($channel->type == $singleChannelType->type)
                {
                    $status = $singleChannelType->getStatus($message->id);
                    $message->channels()->updateExistingPivot($channel->id, [ 'status' => $status ]);
                }
            }
        }
    }

}