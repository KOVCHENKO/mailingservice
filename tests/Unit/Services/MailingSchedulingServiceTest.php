<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\ChannelType\ChannelTypeFactory;
use App\Models\ChannelType\EmailChannel;
use App\Models\ChannelType\SmsChannel;
use App\Models\ChannelType\TelegramChannel;
use App\Models\Message;
use App\Models\ProviderType\SmskaProvider;
use App\Models\ProviderType\SmsRuProvider;
use App\Services\ChannelMailingService;
use App\Services\MailingSchedulingService;
use App\Services\StatusService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class MailingSchedulingServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_scheduling_service_send_failed_messages()
    {
        /* Prepare */
        /* ??? Is it necessary to make mocking or I can leave it as it is ??? */
        $client = new Client();
        $smska = new SmskaProvider($client);
        $smsRu = new SmsRuProvider($client);
        $smsChannel = new SmsChannel($smska, $smsRu);
        $emailChannel = new EmailChannel($client);
        $telegramChannel = new TelegramChannel($client);

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $smsChannel, $emailChannel, $telegramChannel);

        $constructorMessage = new Message();

        $channel = new Channel();
        $statusService = new StatusService($channel);
        $channelMailingService = new ChannelMailingService($statusService, $constructorMessage, $channelTypeFactory);

        /* Creating FailingMessages */
        $message = factory(Message::class)->create();
        $channel = factory(Channel::class)->create();
        DB::table('messages_channels')->insert(
            ['message_id' => $message->id, 'channel_id' => $channel->id, 'status' => 'failed', 'attempts' => 5]
        );

        /* Make */
        $mailingSchedulingService = new MailingSchedulingService($constructorMessage, $channelMailingService);
        $result = $mailingSchedulingService->attemptToSendAgain();

        /* Assert */
        $this->assertEquals(true, $result);
    }


}
