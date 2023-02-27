<?php
/**
 * @var string $message
 */
?>
<p>
    Вы зарегистрировались на сайте
    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/']) ?>" target="_blank"><?= Yii::$app->params['project_name'] ?></a>
    <br />
    <?= $message ?>
</p>
<small>
    Если Вы не регистрировались на сайте <?= Yii::$app->params['project_name'] ?>, пожалуйста, проигнорируйте это письмо.
</small>
