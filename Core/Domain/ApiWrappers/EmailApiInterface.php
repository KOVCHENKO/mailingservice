<?php

namespace Core\Domain\ApiWrappers;


interface EmailApiInterface
{
    public function sendEmail($email, $data);
}