<?php
require_once __DIR__.'/sendTelegram.php';
use telegram\sendTelegram;
use Webmozart\Assert\Assert;

$method = 'sendMessage';

$text = $_POST['telegramMessage'];
//if (!$text) {
//    throw new DomainException("не работает");
//}
Assert::notNull($text, 'нельзя отправить пустое сообщение');

$send_data = [
'text'   => $text
];
$send_data['chat_id'] = '@lazyAxeClan';

$res = sendTelegram::sendTelegramMessage($method, $send_data);



