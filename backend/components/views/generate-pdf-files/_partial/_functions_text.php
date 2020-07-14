<?php
//Liste aller Kategorien und Funktionen

use backend\models\PdfDownload;
use backend\models\PdfDownloadAnswerColor;
use yii\helpers\ArrayHelper;

/* @var $model  \common\models\BaseData */

$connection = Yii::$app->getDb();

$command = $connection->createCommand("
        SELECT DISTINCT 
        tdc.id AS category_id, 
        tdc.name AS category_name, 
        tdf.id AS function_id, 
        tdf.name AS function_name, 
        tdf.description_short AS function_description_short, 
        tdf.description_long AS function_description_long, 
        tda.id AS answer_id, 
        tda.name AS answer_name,
        IF(tdpdac.color IS NULL, :answerStandardColor, tdpdac.color) as color,
        IF(tdpdac.back_color IS NULL, :answerStandardBackColor, tdpdac.back_color) as back_color,
        tdpd.show_weighting,
        tdpd.description_type
        FROM `category_function_answer` AS ta
        INNER JOIN category AS tdc ON ta.category_id = tdc.id
        INNER JOIN answer AS tda ON tda.id = ta.answer_id
        INNER JOIN category_function AS tcf ON tcf.category_id = tdc.id
        INNER JOIN function AS tdf ON tdf.id = ta.function_id AND tcf.function_id = tdf.id AND tcf.is_main_category = 1
        INNER JOIN pdf_download AS tdpd ON tdpd.base_data_id = ta.base_data_id
        INNER JOIN pdf_download_selected_answer AS tdpdas ON tdpdas.pdf_download_id = tdpd.id AND tdpdas.answer_id = tda.id
        INNER JOIN base_data AS tbd ON tbd.id = tdpd.base_data_id
        INNER JOIN category_company_type as tcct ON tcct.category_id = tdc.id AND tcct.company_type_id = tbd.company_type_id
        INNER JOIN function_company_type as tfct ON tfct.function_id = tdf.id AND tfct.company_type_id = tbd.company_type_id
        LEFT JOIN pdf_download_answer_color AS tdpdac ON tdpdac.pdf_download_id = tdpd.id AND tdpdac.answer_id = tda.id
        LEFT JOIN function_restrict_to_project as frtp ON frtp.function_id = tdf.id
        WHERE tdpd.base_data_id = :base_data_id AND (frtp.base_data_id = :base_data_id OR frtp.base_data_id IS NULL)
        ORDER BY tdc.sort, tcf.sort", [
    ':base_data_id'            => $model->id,
    ':answerStandardColor'     => PdfDownloadAnswerColor::STANDARD_COLOR,
    ':answerStandardBackColor' => PdfDownloadAnswerColor::STANDARD_BACK_COLOR,
]);

$result = $command->queryAll();
?>
<div class="function-text">
    <?php $categoryCount = 1; ?>
    <?php if (is_array($result) && 0 < count($result)): ?>
        <h1><?= Yii::t('app','Funktionsbeschreibung')?></h1>
        <?php foreach (ArrayHelper::index($result, null, 'category_name') as $categoryName => $arrMultipleEntryArrays): ?>
            <?php $functionCount = 1 ?>
            <h2> <?= $categoryCount . ' ' . $categoryName ?> </h2>
            <?php foreach ($arrMultipleEntryArrays as $entry): ?>
                <h3><span class="function-category-number"><?= $categoryCount . '.' . str_pad($functionCount++, 3, '0', STR_PAD_LEFT)?></span>&nbsp;&nbsp;—&nbsp;&nbsp;<?= $entry['function_name'] ?></h3>
                <?php if (0 < strlen(trim($entry['function_description_long'])) && $entry['description_type'] == PdfDownload::DESCRIPTION_LONG): ?>
                    <?= $entry['function_description_long'] ?>
                <?php else: ?>
                    <?= $entry['function_description_short'] ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php $categoryCount++ ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
