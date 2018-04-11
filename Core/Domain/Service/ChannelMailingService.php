<?php

namespace Core\Domain\Services;


use Core\Domain\Factory\ChannelTypeFactory;
use Core\Domain\Repository\MessageRepositoryInterface;
use Core\Domain\Service\ChannelService;

class ChannelMailingService
{
    private $channelsArray;
    private $channelService;
    private $messageRepository;

    /**
     * ChannelMailingService constructor.
     */
    public function __construct(
        ChannelService $channelService,
        MessageRepositoryInterface $messageRepository,
        ChannelTypeFactory $channelTypeFactory
    )
    {
        $this->channelService = $channelService;
        $this->messageRepository = $messageRepository;

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
                    $this->channelService->saveStatusFailed($singleChannel, $messageId);
                    continue;
                }

                $attemptResult = $this->channelService->saveStatusSend($singleChannel, $messageId);
            }
        }

        return $attemptResult;
    }

    /**
     * @param $messageId
     * @param $channels
     * Проверить статус сообщения
     */
    public function sync($message)
    {
        return $this->getChannelsForSync($message);
    }

    private function getChannelsForSync($message)
    {
        $status = '';

        foreach ($message->channels as $channel)
        {
            if($channel->pivot->status == config('statuses.1'))
            {
                $status = $this->checkRemoteChannelStatus($channel, $message);
                $this->messageRepository->updateMessageStatus($channel, $status);
            }
        }

        return $status;
    }

    private function checkRemoteChannelStatus($channel, $message)
    {
        $status = '';

        foreach ($this->channelsArray as $singleChannelType)
        {
            if($channel->type == $singleChannelType->type)
            {
                $status = $singleChannelType->getRemoteStatus($message->id);
            }
        }

        return $status;
    }

}