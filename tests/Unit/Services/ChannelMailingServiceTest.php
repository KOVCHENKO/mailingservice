<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelType\ChannelTypeFactory;
use App\Models\Message;
use App\Services\ChannelMailingService;
use App\Services\ChannelService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class ChannelMailingServiceTest extends TestCase
{
    use DatabaseTransactions;

    private $channelMailingService;

    private $smsChannel;
    private $emailChannel;
    private $telegramChannel;
    private $messageModel;

    protected function setUp()
    {
        parent::setUp();

        $this->smsChannel = Mockery::mock('App\Models\ChannelType\SmsChannel');
        $this->emailChannel = Mockery::mock('App\Models\ChannelType\EmailChannel');
        $this->telegramChannel = Mockery::mock('App\Models\ChannelType\TelegramChannel');
        $this->messageModel = Mockery::mock('App\Models\Message');
        $this->channelModel = Mockery::mock('App\Models\Channel');
    }


    public function test_channel_mailing_service_can_send_to_different_channels()
    {
        /* Prepare */
        $connectionData = [
            'contact' => '1',
            'data' => '1'
        ];

        $this->emailChannel->shouldReceive('send')
            ->with($connectionData)
            ->once()
            ->andReturn(true);

        $this->telegramChannel->shouldReceive('send')
            ->with($connectionData)
            ->once()
            ->andReturn(true);

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $this->smsChannel, $this->emailChannel, $this->telegramChannel);

        $channel = new Channel();
        $statusService = new ChannelService($channel);

        $this->channelMailingService = new ChannelMailingService($statusService, $this->messageModel, $channelTypeFactory);


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

        $this->telegramChannel->shouldReceive('getStatus')
            ->with($message->id)
            ->once()
            ->andReturn(config('statuses.3'));

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $this->smsChannel, $this->emailChannel, $this->telegramChannel);

        $statusService = new ChannelService($this->channelModel);
        $this->channelMailingService = new ChannelMailingService($statusService, $this->messageModel, $channelTypeFactory);

        /* Make */
        $result = $this->channelMailingService->getMessageStatus($message);

        /* Assert */
        $this->assertEquals(config('statuses.3'), $result);

    }




}
