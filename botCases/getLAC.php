<?php
if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->start();

$channel = '-1001433544229';
$offset_id = 0;
$limit = 100;

$messages_Messages = $MadelineProto->messages->getHistory(
    ['peer' => $channel,
        'offset_id' => 0,
        'offset_date' => 0,
        'add_offset' => 0,
        'limit' => $limit,
        'max_id' => 9999999999,
        'min_id' => 0,
        'hash' => 0]);
echo json_encode($messages_Messages);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>LACBot</title>
</head>
<body>
<h1>LazyAxeClan_Bot</h1>
<br>
<hr>
<h3>Все нормально, все хорошо, работаем</h3>
<hr>
</body>
</html>
