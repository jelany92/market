<?php
//Schluss-Seite

use backend\models\Attachment;

/* @var $model  \common\models\BaseData */
/* @var $attachment Attachment */

$attachment = Attachment::find()->baseData($model)->finalPage()->one();
if ($attachment instanceof Attachment)
{
    echo $attachment->text;
}
?>
