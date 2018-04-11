<?php

namespace Tests\Unit;

use App\Http\Controllers\ChannelController;
use App\Models\Channel;
use Core\Domain\Repository\ChannelRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Collection;
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
        $channels = factory(Channel::class, 3)->create();

        $channelModel = Mockery::mock(ChannelRepositoryInterface::class);
        $channelModel->shouldReceive('getAll')
            ->with()
            ->once()
            ->andReturn($channels);
        $channelController = new ChannelController($channelModel);

        /* Make */
        $result = $channelController->getAll();

        /* Assert */
        $this->assertEquals(3, $result->count());
    }


}
