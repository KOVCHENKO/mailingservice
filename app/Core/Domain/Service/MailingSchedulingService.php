<?php

namespace App\Services;


use App\Core\Domain\Services\ChannelMailingService;
use App\Models\Message;

class MailingSchedulingService
{

    private $message;
    private $channelMailingService;

    /**
     * MailingSchedulingService constructor.
     * @param $message
     * @param $channelMailingService
     */
    public function __construct(Message $message, ChannelMailingService $channelMailingService)
    {
        $this->message = $message;
        $this->channelMailingService = $channelMailingService;
    }

    /**
     * Разослать сообщения со статусом failed
     */
    public function attemptToSendAgain()
    {
        /* Получить все неотправленные сообщения */
        $failedMessageChannels = $this->message->with('failedChannels')->get();

        foreach ($failedMessageChannels as $failedMessageChannel)
        {
            /* Отобрать все типы failed каналов для сообщения */
            $channelsArray = array();
            foreach($failedMessageChannel->failedChannels as $failedChannel) {
                array_push($channelsArray, $failedChannel->type);
            }

            /* Запустить процесс повторной отсылки */
            $attemptResult = $this->channelMailingService->sendToDifferentChannels(
                $channelsArray,
                [
                    'contact' => $failedMessageChannel->contact,
                    'data' => $failedMessageChannel->data
                ],
                $failedMessageChannel->id);

            return $attemptResult;
        }
    }


}