<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 4/9/18
 * Time: 10:24 AM
 */

namespace App\Core\Persistence\Repository;


use App\Core\Domain\Repository\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageRepository implements MessageRepositoryInterface
{
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getAll()
    {
        return $this->message->with('channels')->get();
    }


    public function create($data)
    {
        return $this->message->create([
            'type' => $data->type,
            'contact' => $data->contact,
            'data' => $data->data,
        ]);
    }

    public function getMessageWithChannels($messageId)
    {
        return $this->message->where('id', $messageId)->with('channels')->first();
    }

    public function getFailedMessages()
    {
        $message = $this->message
            ->with('failedChannels')
            ->get();

        return $message->filter(function ($value, $key) {
            return $value->failedChannels->count() > 0;
        });
    }

    public function updateMessageStatus($channel, $status)
    {
        DB::table('messages_channels')
            ->where([
                'message_id' => $channel->pivot->message_id,
                'channel_id' => $channel->pivot->channel_id,
            ])
            ->update(['status' => $status]);
    }
}