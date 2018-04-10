<?php

namespace App\Services;


use App\Core\Domain\Repository\MessageRepositoryInterface;
use App\Core\Domain\Service\ChannelService;
use App\Core\Domain\Services\ChannelMailingService;
use App\Models\Message;

class MailingSchedulingService
{
    private $messageRepository;
    private $channelService;
    private $channelMailingService;

    /**
     * MailingSchedulingService constructor.
     * @param MessageRepositoryInterface $messageRepository
     * @param ChannelService $channelService
     * @param ChannelMailingService $channelMailingService
     */
    public function __construct(MessageRepositoryInterface $messageRepository,
                                ChannelService $channelService,
                                ChannelMailingService $channelMailingService)
    {
        $this->messageRepository = $messageRepository;
        $this->channelService = $channelService;
        $this->channelMailingService = $channelMailingService;
    }

    public function attemptToSendAgain()
    {
        $failedMessages = $this->messageRepository->getFailedMessages();

        foreach ($failedMessages as $failedMessage)
        {
            $channelTypesForSending = $this->channelService->getChannelTypesForSending($failedMessage);

            $attemptResult = $this->channelMailingService->sendToDifferentChannels(
                $channelTypesForSending,
                [
                    'contact' => $failedMessage->contact,
                    'data' => $failedMessage->data
                ],
                $failedMessage->id);

        }

        return $attemptResult;
    }


}