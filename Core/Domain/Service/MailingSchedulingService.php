<?php

namespace Core\Domain\Services;


use Core\Domain\Repository\MessageRepositoryInterface;
use Core\Domain\Service\ChannelService;

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