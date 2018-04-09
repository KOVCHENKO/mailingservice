<?php

namespace App\Core\Domain\Factory;


use App\Core\Domain\Entity\ChannelType\EmailChannel;
use App\Core\Domain\Entity\ChannelType\SmsChannel;
use App\Core\Domain\Entity\ChannelType\TelegramChannel;
use Illuminate\Support\Collection;

class ChannelTypeFactory
{
    public $channelsCollection = array();

    /**
     * ChannelTypeFactory constructor.
     */
    public function __construct(Collection $channelsCollection,

                                SmsChannel $smsChannel,
                                EmailChannel $emailChannel,
                                TelegramChannel $telegramChannel)
    {
        $channelsCollection = collect([$smsChannel, $emailChannel, $telegramChannel]);

        $this->channelsCollection = $channelsCollection;
    }

}