<?php

namespace Core\Domain\Repository;


interface ChannelRepositoryInterface
{
    public function getAll();

    public function create($request);

    public function saveSendStatus($channelModel, $messageId, $channelEntity);

    public function saveFailedStatus($channelModel, $messageId, $channelEntity);

    public function reduceOneAttempt($channelId, $messageId);

    public function updateStatus($channelModel, $messageId, $status);

    public function getByType($type);
}