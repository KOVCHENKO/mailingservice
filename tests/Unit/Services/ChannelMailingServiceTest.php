<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Message;
use Core\Domain\Entity\ChannelType\EmailChannel;
use Core\Domain\Entity\ChannelType\SmsChannel;
use Core\Domain\Entity\ChannelType\TelegramChannel;
use Core\Domain\Factory\ChannelTypeFactory;
use Core\Domain\Repository\MessageRepositoryInterface;
use Core\Domain\Service\ChannelService;
use Core\Domain\Services\ChannelMailingService;
use Core\Persistence\Repository\MessageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
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

        $this->smsChannel = Mockery::mock(SmsChannel::class);
        $this->emailChannel = Mockery::mock(EmailChannel::class);
        $this->telegramChannel = Mockery::mock(TelegramChannel::class);
        $this->messageModel = Mockery::mock(Message::class);
        $this->channelModel = Mockery::mock(Channel::class);
    }


    public function test_channel_mailing_service_can_send_to_different_channels()
    {
        /* Prepare */
        $connectionData = [
            'contact' => '1',
            'data' => '1'
        ];

        $this->telegramChannel->shouldReceive('send')
            ->with($connectionData)
            ->once()
            ->andReturn(true);

        $collection = Mockery::mock(Collection::class);
        $channelTypeFactory = new ChannelTypeFactory($collection, $this->smsChannel, $this->emailChannel, $this->telegramChannel);

        /* Write into DB */
        $message = factory(Message::class)->create();

        $channelService = Mockery::mock(ChannelService::class);
        $channelService->shouldReceive('saveStatusSend')
            ->with($this->telegramChannel, $message->id)
            ->once()
            ->andReturn(true);

        $messageRepository = Mockery::mock(MessageRepositoryInterface::class);
        $this->channelMailingService = new ChannelMailingService($channelService, $messageRepository, $channelTypeFactory);

        $channelsArray = array('telegram');
        $contactData = [
            'contact' => '1',
            'data' => '1'
        ];

        /* Make */
        $result = $this->channelMailingService->sendToDifferentChannels($channelsArray, $contactData, $message->id);

        /* Assert */
        $this->assertEquals(true, $result);
    }

    public function test_message_sync_status_is_delivered()
    {
        /* Prepare */
        /* Write into DB */
        $message = factory(Message::class)->create();
        $channel = factory(Channel::class)->create();
        DB::table('messages_channels')->insert(
            ['message_id' => $message->id, 'channel_id' => $channel->id, 'status' => config('statuses.1'), 'attempts' => 5]
        );

        $this->telegramChannel->shouldReceive('getRemoteStatus')
            ->with($message->id)
            ->once()
            ->andReturn(config('statuses.3'));

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $this->smsChannel, $this->emailChannel, $this->telegramChannel);

        $channelService = Mockery::mock(ChannelService::class);

        $messageRepository = new MessageRepository($message);

        $this->channelMailingService = new ChannelMailingService($channelService, $messageRepository, $channelTypeFactory);


        /* Make */
        $result = $this->channelMailingService->sync($message);

        /* Assert */
        $this->assertEquals(config('statuses.3'), $result);

    }




}
