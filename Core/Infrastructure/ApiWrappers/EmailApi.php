<?php

namespace Core\Infrastructure\ApiWrappers;


use Core\Domain\ApiWrappers\EmailApiInterface;

class EmailApi implements EmailApiInterface
{
    public function sendEmail($email, $data)
    {
        /*
        Mail::to($connectionData['contact'])->send(new NotificationEmail(
            'Дорогой'.$connectionData['data'].'! Спасибо за регистрацию!'
        ));
        */
    }
}