<?php

namespace telegram;

require_once __DIR__.'/sendTelegram.php';

use DomainException;
use telegram\sendTelegram;

$method = 'sendMessage';

$text = $_POST['telegramMessage'];
if (!$text) {
    throw new DomainException("не работает");
}

//\Webmozart\Assert\Assert::notNull($text, 'низя так');
$send_data = [
'text'   => $text
];
$send_data['chat_id'] = '@lazyAxeClan';

$res = sendTelegram::sendTelegramMessage($method, $send_data);



