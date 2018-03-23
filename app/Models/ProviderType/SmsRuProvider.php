<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 3/23/18
 * Time: 11:28 AM
 */

namespace App\Models\ProviderType;


class SmsRuProvider implements ProviderTypeInterface
{

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