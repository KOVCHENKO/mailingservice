<?php

namespace App\Models\ChannelType;

use App\Mail\NotificationEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

class EmailChannel implements ChannelInterface
{
    public $type = 'email';
    private $client;

    /**
     * EmailChannel constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function send($connectionData)
    {
        /*
        Mail::to($connectionData['contact'])->send(new NotificationEmail(
            'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!'
        ));
        */

        return true;
    }

    public function getStatus($messageId)
    {
        /*
        $res = $this->request('GET', 'http://smska.ru/api.php', [
            'query' => [
                'phone' => $connectionData['contact'],
                'data' => 'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!',
            ]
        ]);

        $result = $res->getBody();
        */

        return 'delivered';

    }
}
