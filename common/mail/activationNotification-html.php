<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $user common\models\AdminUser */
?>
<div class="password-reset">
    <p>Hallo <?= Html::encode($user->username) ?>,</p>

    <p>Für folgenden Benutzer wurde der Account heute freigeschalten:</p>
    <dl>
        <dt>Name:</dt>
        <dd><?= $user->last_name?></dd>
        <dt>Vorname:</dt>
        <dd><?= $user->first_name?></dd>
        <dt>Benutzername:</dt>
        <dd><?= $user->username?></dd>
        <dt>E-Mail Adresse:</dt>
        <dd><?= $user->email?></dd>
    </dl>
</div>
