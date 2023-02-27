<?php

namespace telegrams\app\transformers;

use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    public function transform($newArray)
    {
        return [
            'id' => $newArray['id'],
            'message' => $newArray['text'],
            'userName' => $newArray['userName'],
            'fullData' =>$newArray['fullData']
        ];
    }
}
