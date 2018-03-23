<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/21/18
 * Time: 3:39 PM
 */

namespace App\Services;


use App\Models\Channel;
use Illuminate\Support\Facades\DB;

class StatusService
{
    private $channel;

    /**
     * ChannelController constructor.
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param $channelType
     * @param $messageId
     * Записать в БД статус об отправке сообщения
     */
    public function saveStatusSend($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType->type);

        if (!$this->checkMessageChannelExistence($specificChannel->id, $messageId)) {
            $specificChannel->messages()->attach($messageId, [
                'status' => 'sent',
                'attempts' => $channelType->attempts
            ]);
        }

        $this->reduceAttemps($specificChannel->id, $messageId);
    }

    /**
     * @param $channelType
     * @param $messageId
     * Сообщение не удалось отправить ни по одному из провайдеров
     */
    public function saveStatusFailed($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType->type);

        if (!$this->checkMessageChannelExistence($specificChannel->id, $messageId)) {
            $specificChannel->messages()->attach($messageId, [
                'status' => 'failed',
                'attempts' => $channelType->attempts
            ]);
        }

        $this->reduceAttemps($specificChannel->id, $messageId);
    }

    /**
     * @param $channelId
     * @param $messageId
     * Заминусовать кол-во попыток
     */
    private function reduceAttemps($channelId, $messageId)
    {
        DB::table('messages_channels')
            ->where(['message_id' => $messageId, 'channel_id' => $channelId ])
            ->decrement('attempts', 1);
    }


    /**
     * @param $channelId
     * @param $messageId
     * Проверить сущестовование записи об отсылке канала/сообщения
     */
    private function checkMessageChannelExistence($channelId, $messageId)
    {

        $mesChan = DB::table('messages_channels')
            ->where(['message_id' => $messageId, 'channel_id' => $channelId ])
            ->first();

        if(!isset($mesChan)) {
            return false;
        } else {
            return true;
        }
    }

}