<?php

namespace telegrams;

//require_once __DIR__ . '/sendTelegram.php';

use DomainException;
use telegrams\app\Domain\Services\SendTelegramService;

//use telegram\Domain\Service\sendTelegram;

class MessageSandler
{
    public function send()
    {
        $text = $_POST['telegramMessage'];
        if (!$text) {
            throw new DomainException("не работает");
        }

        $method = 'sendMessage';
        $send_data['chat_id'] = '@lazyAxeClan';
        $send_data['text'] = $text;

        $telegram = SendTelegramService::class;
        $telegram->sendMessage($method, $send_data);
    }

}




