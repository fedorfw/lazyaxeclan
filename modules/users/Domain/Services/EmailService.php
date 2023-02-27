<?php

namespace users\Domain\Services;

use users\Domain\Interfaces\EmailServiceInterface;
use Yii;

class EmailService implements EmailServiceInterface
{
    private $from = ['admin@lazyaxeclan.site' => 'Клан Ленивого Топора'];

    public function sendRegistration(string $toEmail, string $code)
    {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/site/confirm']);
        $content = Yii::$app->controller->renderFile('@app/modules/users/app/mail/register.php', [
            'message' => "Для подтверждения почты укажите код <b style='font-size: 24px; color: #12a41c'>{$code}</b> на странице <a href='{$url}'>{$url}</a>",
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

    public function sendTestEmail (string $text)
    {
        $htmlBody = Yii::$app->controller->renderFile('@app/mail/layouts/html.php', [
            'content' => $text
        ]);

        Yii::$app->mailer->compose()
            ->setFrom($this->from)
            ->setTo('fedorfw@mail.ru')
            ->setSubject('тестовое письмо от LazyAxeClan')
            ->setHtmlBody($htmlBody)
            ->send();
    }

}
