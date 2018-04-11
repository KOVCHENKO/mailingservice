<?php

namespace Core\Domain\Entity\ChannelType;

use Core\Domain\Factory\ProviderFactory;

class SmsChannel implements ChannelInterface
{
    public $type = 'sms';
    public $attempts = 4;

    private $providers;

    /**
     * EmailChannel constructor.
     * @param $client
     */
    public function __construct(ProviderFactory $providerFactory)
    {
        $this->providers = $providerFactory->getProvidersForThisChannel($this->type);
    }

    public function send($connectionData)
    {
        foreach ($this->providers as $singleProvider)
        {
            $result = $singleProvider->send($connectionData);

            if($result == false) {
                continue;
            }

            return true;
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
