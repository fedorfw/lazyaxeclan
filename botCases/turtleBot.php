<?php

use telegram\sendTelegram;

require_once('weatherApi.php');
require_once ('../modules/telegram/sendTelegram.php');

$data = json_decode(file_get_contents('php://input'), TRUE);
$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');

# Обрабатываем сообщение
switch ($message)
{
    case 'текст':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Вот мой ответ'
        ];
        break;

//    case 'погода':
//        $method = 'sendMessage';
//        $send_data = [
//            'text'   => getTemp()
//        ];
//        break;

    case 'кнопки':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Вот мои кнопки',
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard' => [
                    [
                        ['text' => 'погода'],
                        ['text' => 'Кнопка 2'],
                    ],
                    [
                        ['text' => 'Кнопка 3'],
                        ['text' => 'Кнопка 4'],
                    ]
                ]
            ]
        ];
        break;

    default:
        $method = 'sendMessage';
        $send_data = [
            'text' => 'Не понимаю о чем вы :('
        ];
}

$send_data['chat_id'] = $data['chat']['id'];
$res = sendTelegram::sendTelegramMessage($method, $send_data);
// setWebhook
// https://api.telegram.org/bot6246160973:AAEzhH3DfMBqieE6bmXkSk3vmC02QS7-CWc/setWebhook?url=https://lazyaxeclan.site/botCases/turtleBot.php
?>
<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <title>TurtleBot</title>
</head>
<body>
<h1>Turtle Bot</h1>
</body>
</html>

