<?php

namespace App\Models\ChannelType;

use App\Models\ProviderType\SmskaProvider;
use App\Models\ProviderType\SmsRuProvider;
use GuzzleHttp\Client;

class SmsChannel implements ChannelInterface
{
    public $type = 'sms';
    private $client;

    private $providers = array();

    /**
     * EmailChannel constructor.
     * @param $client
     */
    public function __construct(Client $client,
                                SmskaProvider $smskaProvider, SmsRuProvider $smsRuProvider)
    {
        $this->client = $client;
        array_push($this->providers, $smskaProvider, $smsRuProvider);
    }

    public function send($connectionData)
    {
        foreach ($this->providers as $singleProvider)
        {
            $result = $singleProvider->send($connectionData);

            if($result == false) {
                continue;
            } else {
                return true;
                break;
            }
        }

        return false;


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
