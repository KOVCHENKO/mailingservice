<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 3:39 PM
 */

namespace App\Services;


use App\Models\Channel;

class StatusService
{
    private $channel;
    private $channelMailingService;

    /**
     * ChannelController constructor.
     */
    public function __construct(Channel $channel, ChannelMailingService $channelMailingService)
    {
        $this->channel = $channel;
        $this->channelMailingService = $channelMailingService;
    }

    /**
     * @param $channelType
     * @param $messageId
     * Записать в БД статус об отправке сообщения
     */
    public function saveStatusSend($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType->type);
        $specificChannel->messages()->attach($messageId, [
            'status' => 'sent',
            'attempts' => $channelType->attempts
        ]);
    }

    /**
     * @param $channelType
     * @param $messageId
     * Сообщение не удалось отправить ни по одному из провайдеров
     */
    public function saveStatusFailed($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType->type);
        $specificChannel->messages()->attach($messageId, [
            'status' => 'failed',
            'attempts' => $channelType->attempts
        ]);
    }


    public function attemptToSendAgain()
    {
        $channelsArray = array();
        $contactData = '';
        $messageId = 0;

         $this->channelMailingService->sendToDifferentChannels($channelsArray, $contactData, $messageId);
    }
}