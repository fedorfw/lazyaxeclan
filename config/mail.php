<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'mx1.hosting.reg.ru.',
        'username' => 'admin@lazyaxeclan.site',
        'password' => 'WOW5fandg125',
        'port' => '587',
        'encryption' => 'tsl'
    ]
];