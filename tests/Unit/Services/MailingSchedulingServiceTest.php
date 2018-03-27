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
use Mockery;
use Tests\TestCase;

class MailingSchedulingServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_scheduling_service_send_failed_messages()
    {
        /* Prepare */
        /* ??? How to remake to Mocking ??? */
        $client = new Client();
        $smska = new SmskaProvider($client);
        $smsRu = new SmsRuProvider($client);
        $smsChannel = new SmsChannel($smska, $smsRu);
        $emailChannel = new EmailChannel($client);
        $telegramChannel = new TelegramChannel($client);

        $collection = Mockery::mock('Illuminate\Support\Collection');
        $channelTypeFactory = new ChannelTypeFactory($collection, $smsChannel, $emailChannel, $telegramChannel);

        $message = factory(Message::class)->create();
        $constructorMessage = new Message();


        $channel = new Channel();
        $statusService = new StatusService($channel);
        $channelMailingService = new ChannelMailingService($statusService, $message, $channelTypeFactory);

        /* Make */
        $mailingSchedulingService = new MailingSchedulingService($constructorMessage, $channelMailingService);
        $result = $mailingSchedulingService->attemptToSendAgain();

        /* Assert */
        $this->assertEquals(true, $result);
    }


}
