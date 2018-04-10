<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 4/9/18
 * Time: 10:23 AM
 */

namespace App\Core\Domain\Repository;


interface MessageRepositoryInterface
{
    public function getAll();

    public function create($data);

    public function getMessageWithChannels($messageId);

    public function getFailedMessages();

    public function updateMessageStatus($channel, $status);
}