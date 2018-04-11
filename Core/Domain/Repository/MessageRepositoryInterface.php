<?php

namespace Core\Domain\Repository;


interface MessageRepositoryInterface
{
    public function getAll();

    public function create($data);

    public function getMessageWithChannels($messageId);

    public function getFailedMessages();

    public function updateMessageStatus($channel, $status);
}