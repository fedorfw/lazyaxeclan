<?php

namespace app\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/users';

    public $css = [];
    public $js = [
        'js/vue.js'
    ];

    public $depends = [];
}
