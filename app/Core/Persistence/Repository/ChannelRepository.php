<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 4/9/18
 * Time: 10:24 AM
 */

namespace App\Core\Persistence\Repository;


use App\Core\Domain\Repository\ChannelRepositoryInterface;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;

class ChannelRepository implements ChannelRepositoryInterface
{
    private $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function getAll()
    {
        return $this->channel->all();
    }

    public function create($data)
    {
        $this->channel->create([
            'name' => $data->name,
            'type' => $data->type
        ]);
    }


    public function saveSendStatus($channelModel, $messageId, $channelEntity)
    {
        $channelModel->messages()->attach($messageId, [
            'status' => config('statuses.1'),
            'attempts' => $channelEntity->attempts
        ]);
    }

    public function saveFailedStatus($channelModel, $messageId, $channelEntity)
    {
        return $channelModel->messages()->attach($messageId, [
            'status' => config('statuses.2'),
            'attempts' => $channelEntity->attempts
        ]);
    }

    public function reduceOneAttempt($channelId, $messageId)
    {
        DB::table('messages_channels')
            ->where(['message_id' => $messageId, 'channel_id' => $channelId ])
            ->decrement('attempts', 1);
    }

    public function updateStatus($channelModel, $messageId, $status)
    {
        DB::table('messages_channels')
            ->where([
                'message_id' => $messageId,
                'channel_id' => $channelModel->id,
            ])
            ->update(['status' => $status]);
    }

    public function getByType($type)
    {
        return $this->channel->getByType($type);
    }
}