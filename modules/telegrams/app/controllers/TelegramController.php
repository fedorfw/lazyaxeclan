<?php

namespace telegrams\app\controllers;

use app\modules\common\components\BaseApiController;

class TelegramController extends BaseApiController
{
    public function actionTest()
    {
        return $this->apiSuccess();
    }
}
