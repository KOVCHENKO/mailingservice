<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Все каналы
     */
    public function getAll()
    {
        return $this->channel->all();
    }

    /**
     * @param $channelType
     * @param $messageId
     * Записать в БД статус об отправке сообщения
     */
    public function saveStatusSend($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType);
        $specificChannel->messages()->attach($messageId, ['status' => 'sent']);
    }

    /**
     * @param $channelType
     * @param $messageId
     * Сообщение не удалось отправить ни по одному из провайдеров
     */
    public function saveStatusFailed($channelType, $messageId)
    {
        $specificChannel = $this->channel->getByType($channelType);
        $specificChannel->messages()->attach($messageId, ['status' => 'failed']);
    }
}
