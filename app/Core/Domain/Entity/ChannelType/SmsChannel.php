<?php

namespace App\Core\Domain\Entity\ChannelType;

use App\Core\Domain\Models\ProviderType\SmskaProvider;
use App\Core\Domain\Models\ProviderType\SmsRuProvider;
use GuzzleHttp\Client;

class SmsChannel implements ChannelInterface
{
    public $type = 'sms';
    public $attempts = 4;

    private $providers = array();

    /**
     * EmailChannel constructor.
     * @param $client
     */
    public function __construct(SmskaProvider $smskaProvider, SmsRuProvider $smsRuProvider)
    {
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

    public function getRemoteStatus($messageId)
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

        return config('statuses.3');
    }
}
