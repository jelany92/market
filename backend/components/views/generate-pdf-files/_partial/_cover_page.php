<?php
//Deckblatt

use backend\models\Attachment;

/* @var $model  \common\models\BaseData */
/* @var $attachment Attachment */

$attachment = Attachment::find()->baseData($model)->coverPage()->one();
if ($attachment instanceof Attachment)
{
    echo $attachment->text;
}
?>