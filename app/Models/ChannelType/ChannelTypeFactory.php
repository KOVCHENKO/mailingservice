<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/26/18
 * Time: 2:50 PM
 */

namespace App\Models\ChannelType;


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