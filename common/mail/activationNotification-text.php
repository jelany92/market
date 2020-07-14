<?php

/* @var $this yii\web\View */
/* @var $user common\models\AdminUser */

?>
Hallo <?= $user->username ?>,

Für folgenden Benutzer wurde der Account heute freigeschalten:

Name: <?= $user->last_name?>
Vorname: <?= $user->first_name?>
Benutzername: <?= $user->username?>
E-Mail Adresse:: <?= $user->email?>