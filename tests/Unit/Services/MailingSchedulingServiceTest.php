<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Message;
use Core\Domain\Entity\ChannelType\EmailChannel;
use Core\Domain\Entity\ChannelType\SmsChannel;
use Core\Domain\Entity\ChannelType\TelegramChannel;
use Core\Domain\Factory\ChannelTypeFactory;
use Core\Domain\Models\ProviderType\SmskaProvider;
use Core\Domain\Models\ProviderType\SmsRuProvider;
use Core\Domain\Service\ChannelService;
use Core\Domain\Services\ChannelMailingService;
use Core\Domain\Services\MailingSchedulingService;
use Core\Persistence\Repository\ChannelRepository;
use Core\Persistence\Repository\MessageRepository;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class MailingSchedulingServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_scheduling_service_send_sent_all_failed_messages()
    {
        /* Creating FailingMessages */
        $message = factory(Message::class)->create();
        $channel = factory(Channel::class)->create();
        DB::table('messages_channels')->insert(
            ['message_id' => $message->id, 'channel_id' => $channel->id, 'status' => 'failed', 'attempts' => 5]
        );

        /* Prepare */
        $smska = new SmskaProvider(new Client());
        $smsRu = new SmsRuProvider(new Client());
        $smsChannel = new SmsChannel($smska, $smsRu);
        $emailChannel = new EmailChannel(new Client());
        $telegramChannel = new TelegramChannel(new Client());

        $collection = Mockery::mock(Collection::class);
        $channelTypeFactory = new ChannelTypeFactory($collection, $smsChannel, $emailChannel, $telegramChannel);

        $messageRepository = new MessageRepository(new Message());

        $channelRepository = new ChannelRepository(new Channel);
        $channelService = new ChannelService($channelRepository);
        $channelMailingService = new ChannelMailingService($channelService, $messageRepository, $channelTypeFactory);


        /* Make */
        $mailingSchedulingService = new MailingSchedulingService($messageRepository, $channelService, $channelMailingService);
        $result = $mailingSchedulingService->attemptToSendAgain();

        /* Assert */
        $this->assertEquals(true, $result);
    }


}
