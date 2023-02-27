<?php

namespace users\Domain\UseCases\TestEmailSend;

use users\Domain\Interfaces\EmailServiceInterface;

class Handler
{
    private EmailServiceInterface $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    public function handle(Command $command)
    {

        $this->emailService->sendRegistration('fedorfw@mail.ru', $command->text);



    }
}
