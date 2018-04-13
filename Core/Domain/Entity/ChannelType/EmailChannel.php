<?php

namespace Core\Domain\Entity\ChannelType;

use App\Mail\NotificationEmail;
use Core\Domain\ApiWrappers\CurlApiInterface;
use Core\Domain\ApiWrappers\EmailApiInterface;
use Illuminate\Support\Facades\Mail;

class EmailChannel implements ChannelInterface
{
    public $type = 'email';
    public $attempts = 6;

    private $curlApi;
    private $emailApi;

    /**
     * EmailChannel constructor.
     * @param $client
     */
    public function __construct(CurlApiInterface $curlApi, EmailApiInterface $emailApi)
    {
        $this->curlApi = $curlApi;
        $this->emailApi = $emailApi;
    }


    public function send($connectionData)
    {
        $this->emailApi->sendEmail($connectionData['contact'], $connectionData);

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
