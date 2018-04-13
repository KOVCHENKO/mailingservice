<?php

namespace Core\Domain\Entity\ChannelType;

use Core\Domain\ApiWrappers\CurlApiInterface;

class TelegramChannel implements ChannelInterface
{
    public $type = 'telegram';
    public $attempts = 3;

    private $curlApi;

    /**
     * TelegramChannel constructor.
     * @param $curlApi
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

        return true;
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
