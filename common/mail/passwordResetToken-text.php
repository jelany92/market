<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink String */

?>
Hallo <?= Html::encode($user->first_name) . ' ' . Html::encode($user->last_name) ?>,

benutze den folgenden Link um dein Passwort neu zu setzen:

<?= $resetLink ?>

Dein Benutzername lautet: <?= Html::encode($user->username)?>
