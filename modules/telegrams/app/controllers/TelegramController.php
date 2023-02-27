<?php

namespace telegrams\app\controllers;

require_once __DIR__.'/../../../../botCases/weatherApi.php';

use app\modules\common\components\BaseApiController;
use DomainException;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceAbstract;
use telegrams\app\transformers\MessageTransformer;
use telegrams\Domain\Services\SendTelegramService;
use Yii;

class TelegramController extends BaseApiController
{
    public function actionSend()
    {
        $text = $this->getJsonRest();
        if (!$text) {
            throw new DomainException("не работает");
        }

        $method = 'sendMessage';
        $send_data['text'] = $text->message;
        SendTelegramService::sendMessage( $method, $send_data);

        return $this->apiSuccess();
    }

    public function actionGetMessage()
    {
        $method = 'sendMessage';
        $get_msg = file_get_contents("https://api.telegram.org/bot6246160973:AAEzhH3DfMBqieE6bmXkSk3vmC02QS7-CWc/getUpdates");
        $get_msg_decode = json_decode($get_msg);
        $resp = $get_msg_decode->result;
        if (count($resp) >= 1) {
            foreach ($resp as $key => $item) {
                $newArray[$key] = [
                    'id' => $item->update_id,
                    'text' => $item->channel_post->text,
                    'userName' => $item->channel_post->sender_chat->username,
                    'fullData' => $item,
                ];
            $text = $item->channel_post->text;
            if ($text == 'погода') {
                $send_data['text'] = getTemp();
                SendTelegramService::sendMessage( $method, $send_data);
            } elseif ($text == 'привет') {
                $send_data['text'] = 'Привет, я бот тыц тыц тыц';
                SendTelegramService::sendMessage( $method, $send_data);
            } elseif ($text == 'сайт' || $text == 'откуда ты?' || $text == 'ссылка') {
                $send_data['text'] = 'Наш сайт https://lazyaxeclan.site/ добро пожаловать';
                SendTelegramService::sendMessage( $method, $send_data);
            }

            $id = $item->update_id+1;
            file_get_contents("https://api.telegram.org/bot6246160973:AAEzhH3DfMBqieE6bmXkSk3vmC02QS7-CWc/getUpdates?offset=" . $id);
            }

            $collection = new Collection(
                $newArray,
                new MessageTransformer()
            );
            return (new Manager())
                ->createData($collection)
                ->toArray();
        }
    return $this->apiSuccess();
    }
}
