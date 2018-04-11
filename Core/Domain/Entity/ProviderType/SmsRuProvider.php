<?php

namespace Core\Domain\Models\ProviderType;


use GuzzleHttp\Client;

class SmsRuProvider implements ProviderTypeInterface
{
    private $client;
    public $channelType = 'sms';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($connectionData)
    {
        /*
        $res = $this->client->request('GET', 'http://smsru.ru/api.php', [
            'query' => [
                'phone' => $connectionData['contact'],
                'data' => 'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!',
            ]
        ]);

        $result = $res->getBody();
        */

        return true;
    }
}