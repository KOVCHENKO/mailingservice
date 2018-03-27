<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelType\ChannelTypeFactory;
use App\Models\Message;
use App\Services\ChannelMailingService;
use App\Services\StatusService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class ChannelMailingServiceTest extends TestCase
{
    use DatabaseTransactions;

    private $channelMailingService;

    protected function setUp()
    {
        parent::setUp();

    }


    public function test_channel_mailing_service_can_send_to_different_channels()
    {
        /* Prepare */
        $connectionData = [
            'contact' => '1',
            'data' => '1'
        ];

        $smsChannel = Mockery::mock('App\Models\ChannelType\SmsChannel');

        $emailChannel = Mockery::mock('App\Models\ChannelType\EmailChannel');
        $emailChannel->shouldReceive('send')
            ->with($connectionData)
            ->once()
            ->andReturn(true);


        $telegramChannel = Mockery::mock('App\Models\ChannelType\TelegramChannel');
        $telegramChannel->shouldReceive('send')
            ->with($connectionData)
            ->once()
            ->andReturn(true);

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $smsChannel, $emailChannel, $telegramChannel);

        $channel = new Channel();
        $message = new Message();
        $statusService = new StatusService($channel);

        $this->channelMailingService = new ChannelMailingService($statusService, $message, $channelTypeFactory);


        $message = factory(Message::class)->create();

        $channelsArray = array('telegram', 'email');
        $contactData = [
            'contact' => '1',
            'data' => '1'
        ];

        /* Make */
        $result = $this->channelMailingService->sendToDifferentChannels($channelsArray, $contactData, $message->id);

        /* Assert */
        $this->assertEquals(true, $result);
    }

    public function test_message_status_is_delivered()
    {
        /* Prepare */
        $message = factory(Message::class)->create();
        $channel = factory(Channel::class)->create();
        DB::table('messages_channels')->insert(
            ['message_id' => $message->id, 'channel_id' => $channel->id, 'status' => 'sent', 'attempts' => 5]
        );

        $smsChannel = Mockery::mock('App\Models\ChannelType\SmsChannel');

        $emailChannel = Mockery::mock('App\Models\ChannelType\EmailChannel');

        $telegramChannel = Mockery::mock('App\Models\ChannelType\TelegramChannel');
        $telegramChannel->shouldReceive('getStatus')
            ->with($message->id)
            ->once()
            ->andReturn(config('statuses.3'));

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $smsChannel, $emailChannel, $telegramChannel);

        $channel = new Channel();
        $messageModel = new Message();
        $statusService = new StatusService($channel);
        $this->channelMailingService = new ChannelMailingService($statusService, $messageModel, $channelTypeFactory);

        /* Make */
        $result = $this->channelMailingService->getMessageStatus($message);

        /* Assert */
        $this->assertEquals(config('statuses.3'), $result);

    }




}
