<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => true,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'mail.lazyaxeclan.site',
        'username' => 'WOW5fandg125',
        'password' => 'WOW5fandg125',
        'port' => '465',
        'encryption' => 'ssl'
    ]
];