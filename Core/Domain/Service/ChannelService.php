<?php

namespace Core\Domain\Service;


use Core\Domain\Repository\ChannelRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChannelService
{
    /**
     * ChannelController constructor.
     */
    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * @param $channelEntity
     * @param $messageId
     * Записать в БД статус об отправке сообщения
     */
    public function saveStatusSend($channelEntity, $messageId)
    {
        $channelModel = $this->channelRepository->getByType($channelEntity->type);

        if (!$this->checkMessageChannelExistence($channelModel->id, $messageId)) {
            $this->channelRepository->saveSendStatus($channelModel, $messageId, $channelEntity);
        }

        $this->channelRepository->updateStatus($channelModel, $messageId, config('statuses.1'));

        $this->reduceAttemps($channelModel->id, $messageId);

        return true;
    }

    /**
     * @param $channelEntity
     * @param $messageId
     * Сообщение не удалось отправить ни по одному из провайдеров
     */
    public function saveStatusFailed($channelEntity, $messageId)
    {
        $channelModel = $this->channelRepository->getByType($channelEntity->type);

        if (!$this->checkMessageChannelExistence($channelModel->id, $messageId)) {
            $this->channelRepository->saveFailedStatus($channelModel, $messageId, $channelEntity);
        }

        $this->channelRepository->updateStatus($channelModel, $messageId, config('statuses.2'));

        $this->reduceAttemps($channelModel->id, $messageId);

        return true;
    }

    /**
     * @param $channelId
     * @param $messageId
     * Заминусовать кол-во попыток
     */
    private function reduceAttemps($channelId, $messageId)
    {
        $this->channelRepository->reduceOneAttempt($channelId, $messageId);
    }


    /**
     * @param $channelId
     * @param $messageId
     * Проверить сущестовование записи об отсылке канала/сообщения
     * TODO: Убрать if_else - оставить if
     */
    private function checkMessageChannelExistence($channelId, $messageId)
    {
        $mesChan = DB::table('messages_channels')
            ->where(['message_id' => $messageId, 'channel_id' => $channelId ])
            ->first();

        return isset($mesChan);
    }


    public function getChannelTypesForSending($failedMessage)
    {
        $channelsArray = array();
        foreach($failedMessage->failedChannels as $failedChannel) {
            array_push($channelsArray, $failedChannel->type);
        }

        return $channelsArray;
    }
}