<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $user common\models\AdminUser */
/* @var $resetLink String */

?>
<div class="password-reset">
    <p>Hallo <?= Html::encode($user->first_name) . ' ' . Html::encode($user->last_name) ?>,</p>

    <p>benutze den folgenden Link um dein Passwort neu zu setzen:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>Dein Benutzername lautet: <?= Html::encode($user->username)?></p>
</div>
