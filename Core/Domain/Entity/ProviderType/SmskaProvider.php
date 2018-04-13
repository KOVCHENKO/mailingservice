<?php

namespace Core\Domain\Models\ProviderType;


use Core\Domain\ApiWrappers\CurlApiInterface;

class SmskaProvider implements ProviderTypeInterface
{
    private $curlApi;
    public $channelType = 'sms';

    /**
     * SmskaProvider constructor.
     * @param $client
     */
    public function __construct(CurlApiInterface $curlApi)
    {
        $this->curlApi = $curlApi;
    }


    public function send($connectionData)
    {
        $dataArray = [
            'phone' => $connectionData['contact'],
            'data' => 'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!',
        ];

        $result = $this->curlApi->makeGetRequest('http://smska.ru/api.php', $dataArray);

        return false;
    }

    public function getRemoteStatus($messageId)
    {
        $dataArray = [
            'message_id' => $messageId,
        ];

        $this->curlApi->makeGetRequest('http://smska.ru/api.php', $dataArray);

        return config('statuses.3');
    }
}