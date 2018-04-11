<?php

namespace Tests\Unit;

use App\Models\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;


    public function test_message_can_be_created()
    {
        /* Prepare */
        $dummyMessage = [
            'type' => 'register',
            'contact' => '89170863638',
            'data' => 'register',
            'channel_type' => array('telegram')
        ];

        /* Make */
        $response = $this->call('POST', '/message/create', $dummyMessage);

        /* Assert */
        $this->assertEquals(302, $response->getStatusCode());
    }


    public function test_message_sync()
    {
        /* Prepare */
        $message = factory(Message::class)->create();

        /* Make */
        $response = $this->call('GET', '/message/sync/'.$message->id);

        /* Assert */
        $this->assertEquals(302, $response->getStatusCode());
    }


}
