<?php

namespace App\Models\ChannelType;

use GuzzleHttp\Client;

class SmsChannel implements ChannelInterface
{
    public $type = 'sms';
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
        $res = $this->client->request('GET', 'http://smska.ru/api.php', [
            'query' => [
                'phone' => $connectionData['contact'],
                'data' => 'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!',
            ]
        ]);

        $result = $res->getBody();
        */

        return true;
    }

    public function getStatus($messageId)
    {
        /*
        $res = $this->client->request('GET', 'http://smska.ru/api.php', [
            'query' => [
                '' => $connectionData['contact'],
                'data' => 'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!',
            ]
        ]);

        $result = $res->getBody();
        */

        return 'delivered';
    }
}
