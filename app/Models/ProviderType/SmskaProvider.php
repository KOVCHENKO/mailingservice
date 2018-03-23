<?php

namespace App\Models\ProviderType;


class SmskaProvider implements ProviderTypeInterface
{

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