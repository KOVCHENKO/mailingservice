<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 3:39 PM
 */

namespace App\Services;


use App\Models\ChannelType\ChannelTypeFactory;
use App\Models\Message;

class ChannelMailingService
{
    private $channelsArray;
    private $statusService;
    private $message;
    
    /**
     * ChannelMailingService constructor.
     */
    public function __construct(
        StatusService $statusService, Message $message, ChannelTypeFactory $channelTypeFactory
    )
    {
        $this->statusService = $statusService;
        $this->message = $message;

        $this->channelsArray = $channelTypeFactory->channelsCollection;
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

                if($status == false) {
                    $this->statusService->saveStatusFailed($singleChannel, $messageId);
                }

                $attemptResult = $this->statusService->saveStatusSend($singleChannel, $messageId);
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
        return $this->getChannelsForStatusCheck($message);
    }

    private function getChannelsForStatusCheck($message)
    {
        $status = '';

        foreach ($message->channels as $channel)
        {
            $status = $this->checkChannelStatus($channel, $message);
        }

        return $status;
    }

    private function checkChannelStatus($channel, $message)
    {
        $status = '';

        foreach ($this->channelsArray as $singleChannelType)
        {
            if($channel->type == $singleChannelType->type)
            {
                $status = $singleChannelType->getStatus($message->id);
                $message->channels()
                    ->wherePivot('status', '<>', 'failed')
                    ->updateExistingPivot($channel->id, [ 'status' => $status ]);
            }
        }

        return $status;
    }

}