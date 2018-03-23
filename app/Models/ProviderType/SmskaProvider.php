<?php

namespace App\Models\ProviderType;


use GuzzleHttp\Client;

class SmskaProvider implements ProviderTypeInterface
{
    private $client;

    /**
     * SmskaProvider constructor.
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
        return false;
    }
}