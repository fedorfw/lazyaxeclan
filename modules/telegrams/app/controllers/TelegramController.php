<?php

namespace telegrams\app\controllers;

use app\modules\common\components\BaseApiController;
use DomainException;
use telegrams\Domain\Services\SendTelegramService;
use Yii;

class TelegramController extends BaseApiController
{
    public function actionTest()
    {
        return $this->apiSuccess();
    }

    public function actionSend()
    {
        $text = $_POST['telegramMessage'];
        if (!$text) {
            throw new DomainException("не работает");
        }

        $method = 'sendMessage';
        $send_data['text'] = $text;
        SendTelegramService::sendMessage( $method, $send_data);

        return $this->apiSuccess();
    }
}
