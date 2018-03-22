<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 3:39 PM
 */

namespace App\Services;


use App\Http\Controllers\ChannelController;
use App\Models\Channel;
use App\Models\ChannelType\EmailChannel;
use App\Models\ChannelType\SmsChannel;
use App\Models\ChannelType\TelegramChannel;

class ChannelMailingService
{
    private $channelsArray = array();
    private $channelController;

    /**
     * ChannelMailingService constructor.
     */
    public function __construct(
        ChannelController $channelController,
        SmsChannel $smsChannel, EmailChannel $emailChannel, TelegramChannel $telegramChannel)
    {
        $this->channelController = $channelController;
        array_push($this->channelsArray, $smsChannel, $emailChannel, $telegramChannel);
    }

    /**
     * @param $providersArray
     * @param $messageId
     * @param $contactData
     * Отправка по разным каналам
     */
    public function sendToDifferentChannels($providersArray, $contactData, $messageId)
    {
        foreach ($this->channelsArray as $singleChannel)
        {
            if(in_array($singleChannel->type, $providersArray))
            {
                $singleChannel->send($contactData);
                $this->channelController->saveStatusSend($singleChannel->type, $messageId);
            }
        }
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