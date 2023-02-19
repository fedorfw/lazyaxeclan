<?php
require_once "sendTelegram.php";

$method = 'sendMessage';

$send_data = [
'text'   => $_POST['telegramMessage']
];
$send_data['chat_id'] = '@lazyAxeClan';

$res = sendTelegramMessage($method, $send_data);



