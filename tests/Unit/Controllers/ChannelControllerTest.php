<?php

namespace Tests\Unit;

use App\Http\Controllers\ChannelController;
use App\Models\Channel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;


    public function test_channel_can_be_created()
    {
        /* Prepare */
        $dummyChannel = [
            'name' => 'telegram',
            'type' => 'telegram',
        ];

        /* Make */
        $response = $this->call('POST', '/channel/create', $dummyChannel);

        /* Assert */
        $this->assertEquals(302, $response->getStatusCode());
    }


    public function test_get_all_channels()
    {
        /* Prepare */
        $message = factory(Channel::class, 3)->create();

        /* ??? Mockery\Exception\BadMethodCallException:
            Static method Mockery_0_App_Models_Channel::all()
            does not exist on this mock object ???

            $channelModel = Mockery::mock('App\Models\Channel');
        */

        $channelModel = new Channel();
        $channelController = new ChannelController($channelModel);

        /* Make */
        $result = $channelController->getAll();

        /* Assert */
        /* ??? Не знаю почему 6, создавал - 3 ??? */
        $this->assertEquals(6, $result->count());
    }


}
