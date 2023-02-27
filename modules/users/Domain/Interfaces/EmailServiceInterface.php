<?php

namespace users\Domain\Interfaces;

interface EmailServiceInterface
{
    public function sendRegistration(string $toEmail, string $code);

    public function sendTestEmail (string $text);
}