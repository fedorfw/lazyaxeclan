<?php

namespace users\Domain\Services;

use users\Domain\Interfaces\EmailServiceInterface;
use Yii;

class EmailService implements EmailServiceInterface
{
    private $from = ['admin@lazyaxeclan.site' => 'Клан ленивого Топора'];

    public function sendRegistration(string $toEmail, string $code)
    {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/site/login']);
        $content = Yii::$app->controller->renderFile('@app/modules/users/app/mail/register.php', [
            'message' => "Для подтверждения почты укажите код <b style='font-size: 24px;'>{$code}</b> на странице <a href='{$url}'>{$url}</a>",
        ]);
        $htmlBody = Yii::$app->controller->renderFile('@app/mail/layouts/html.php', [
            'content' => $content
        ]);

        Yii::$app->mailer->compose()
            ->setFrom($this->from)
            ->setTo($toEmail)
            ->setSubject('Регистрация на сайте LazyAxeClan')
            ->setHtmlBody($htmlBody)
            ->send();
    }

}
