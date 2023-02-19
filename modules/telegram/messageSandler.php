<?php

use telegram\sendTelegram;

$method = 'sendMessage';

$send_data = [
'text'   => $_POST['telegramMessage']
];
$send_data['chat_id'] = '@lazyAxeClan';

$res = sendTelegram::sendTelegramMessage($method, $send_data);



