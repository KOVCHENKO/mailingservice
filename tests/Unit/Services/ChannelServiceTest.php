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

class ChannelServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected function tearDown()
    {
        Mockery::close();
    }


    public function test_send_status()
    {
        /* Prepare */
        /*
        $message = factory(Message::class)->create();
        $channel = Mockery::mock('App\Models\Channel');
        $channel->shouldReceive('getByType')
            ->with('telegram')
            ->once();

        $telegramChannel = Mockery::mock('App\Models\ChannelType\TelegramChannel');

        $statusService = new StatusService($channel);
        $statusService->specificChannel = Channel::where('type', 'telegram')->first();
        */

        /* Make */
        //  1) Tests\Unit\ChannelServiceTest::test_send_status
        //  ErrorException: Trying to get property 'id' of non-object
        //
        //  /opt/lampp/htdocs/mailingservice/app/Services/StatusService.php:36
        //  /opt/lampp/htdocs/mailingservice/tests/Unit/Services/ChannelServiceTest.phpp:39
        //  Не выходит протестировать, так как не видит $specificChannel->id, как правильно получить?

//        $result = $statusService->saveStatusSend($telegramChannel, $message->id);

        /* Assert */

    }


}
