<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Message;
use App\Services\ChannelMailingService;
use App\Services\StatusService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\TestCase;

class ChannelMailingServiceTest extends TestCase
{
    use DatabaseTransactions;

    private $channelMailingService;


    public function setUp()
    {
        parent::setUp();
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

        $channel = new Channel();
        $message = new Message();
        $statusService = new StatusService($channel);

        $this->channelMailingService = new ChannelMailingService($statusService, $message,
            $smsChannel, $emailChannel, $telegramChannel);
    }

    /**
     * GeneratorTest constructor.
     */
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_channel_mailing_service_can_send_to_different_channels()
    {
        /* Prepare */
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
}
