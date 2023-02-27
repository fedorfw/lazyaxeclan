<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'mail.lazyaxeclan.site',
        'username' => 'admin@lazyaxeclan.site',
        'password' => 'WOW5fandg125',
        'port' => '465',
        'encryption' => 'ssl'
    ]
];