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

    public function getAll()
    {
        return $this->channel->all();
    }

    public function saveStatusSend($channelType)
    {
        $specificChannel = $this->channel->where('type', $channelType)->first();

    }
}
