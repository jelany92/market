<?php
//Liste aller Kategorien und Funktionen

use backend\models\PdfDownloadAnswerColor;
use backend\models\PdfDownloadSelectedAdditionalContent;
use yii\helpers\ArrayHelper;
use backend\components\GeneratePDFFiles;

/* @var $model  \common\models\BaseData */

$connection = Yii::$app->getDb();

$command = $connection->createCommand("
        SELECT DISTINCT 
        c.id AS category_id, 
        c.name AS category_name, 
        f.id AS function_id, 
        f.name AS function_name, 
        a.id AS answer_id, 
        a.name AS answer_name,
        cfa.test_criteria AS test_criteria,
        IF(pdsac_explain.id IS NOT NULL, 1, 0) AS show_explain,
        IF(pdsac_test.id IS NOT NULL, 1, 0) AS show_test,
        cfa.explain AS `explain`,
        IF(pdac.color IS NULL, :answerStandardColor, pdac.color) AS color,
        IF(pdac.back_color IS NULL, :answerStandardBackColor, pdac.back_color) AS back_color,
        IF(pdacc_test.color IS NULL, :answerStandardColor, pdacc_test.color) AS test_color,
        IF(pdacc_test.back_color IS NULL, :answerStandardBackColor, pdacc_test.back_color) AS test_back_color,
        IF(pdacc_explain.color IS NULL, :answerStandardColor, pdacc_explain.color) AS explain_color,
        IF(pdacc_explain.back_color IS NULL, :answerStandardBackColor, pdacc_explain.back_color) AS explain_back_color,
        pd.show_weighting
        FROM `category_function_answer` AS cfa
        INNER JOIN category AS c ON cfa.category_id = c.id
        INNER JOIN answer AS a ON a.id = cfa.answer_id
        INNER JOIN category_function AS cf ON cf.category_id = c.id
        INNER JOIN function AS f ON f.id = cfa.function_id AND cf.function_id = f.id AND cf.is_main_category = 1
        INNER JOIN pdf_download AS pd ON pd.base_data_id = cfa.base_data_id
        INNER JOIN pdf_download_selected_answer AS pdas ON pdas.pdf_download_id = pd.id AND pdas.answer_id = a.id
        INNER JOIN base_data AS bd ON bd.id = pd.base_data_id
        INNER JOIN category_company_type AS cct ON cct.category_id = c.id AND cct.company_type_id = bd.company_type_id
        INNER JOIN function_company_type AS fct ON fct.function_id = f.id AND fct.company_type_id = bd.company_type_id
        LEFT JOIN pdf_download_answer_color AS pdac ON pdac.pdf_download_id = pd.id AND pdac.answer_id = a.id
        LEFT JOIN function_restrict_to_project AS frtp ON frtp.function_id = f.id
        LEFT JOIN pdf_download_selected_additional_content AS pdsac_explain ON pdsac_explain.pdf_download_id = pd.id AND pdsac_explain.`type` = :type_explain
        LEFT JOIN pdf_download_additional_content_color AS pdacc_explain ON pdacc_explain.pdf_download_id = pd.id AND pdsac_explain.`type` = pdacc_explain.`type` AND cfa.`explain` = 1
        LEFT JOIN pdf_download_selected_additional_content AS pdsac_test ON pdsac_test.pdf_download_id = pd.id AND pdsac_test.`type` = :type_test_criteria
        LEFT JOIN pdf_download_additional_content_color AS pdacc_test ON pdacc_test.pdf_download_id = pd.id AND pdsac_test.`type` = pdacc_test.`type` AND cfa.test_criteria = 1
        WHERE pd.base_data_id = :base_data_id AND (frtp.base_data_id = :base_data_id OR frtp.base_data_id IS NULL)
        ORDER BY c.sort, cf.sort", [
    ':base_data_id'            => $model->id,
    ':answerStandardColor'     => PdfDownloadAnswerColor::STANDARD_COLOR,
    ':answerStandardBackColor' => PdfDownloadAnswerColor::STANDARD_BACK_COLOR,
    ':type_explain'            => PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN,
    ':type_test_criteria'      => PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA,
]);

$result = $command->queryAll();

?>
<?php $categoryCount = 1; ?>
<?php if (is_array($result) && 0 < count($result)): ?>
    <table class="functions_table" width="100%">

        <thead>
        <tr>
            <th></th>
            <?php if ($model->pdfDownload->show_weighting): ?>
                <th></th>
            <?php endif; ?>
            <th></th>
            <th>Anforderung erfüllt?</th>
        </tr>
        </thead>
        <?php foreach (ArrayHelper::index($result, null, 'category_name') as $categoryName => $arrMultipleEntryArrays): ?>
            <?php $functionCount = 1 ?>
            <tr>
                <td colspan="<?= ($model->pdfDownload->show_weighting) ? 4 : 3 ?>"><h2> <?= $categoryCount . ' ' . $categoryName ?> </h2></td>
            </tr>
            <?php foreach ($arrMultipleEntryArrays as $entry): ?>
                <tr>
                    <td width="9%">
                        <?= $categoryCount . '.' . str_pad($functionCount++, 3, '0', STR_PAD_LEFT) ?>
                    </td>
                    <?php if ($model->pdfDownload->show_weighting): ?>
                        <td width="17%">
                            <table>
                                <tr>
                                    <td colspan="2" style="background-color: <?= $entry['back_color'] ?>; width: 100px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: -2px" align="center">
                                        <div align="center" style=" color: <?= $entry['color'] ?>"><?= $entry['answer_name'] ?></div>
                                    </td>
                                </tr>
                                <?php if (($entry['show_test'] && $entry['test_criteria']) || ($entry['show_explain'] && $entry['explain'])): ?>
                                    <tr>
                                        <?php if ($entry['show_test'] && $entry['test_criteria']) : ?>
                                            <td style="width: 50px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 0px; background-color: <?= $entry['test_back_color'] ?>;" align="center">
                                                <div align="center" style="color: <?= $entry['test_color'] ?>">&nbsp;<?= PdfDownloadSelectedAdditionalContent::getPdfTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA] ?>&nbsp;</div>
                                            </td>
                                            <?php if ($entry['show_explain'] && $entry['explain']): ?>
                                                <td style="width: 50px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 0px; background-color: <?= $entry['explain_back_color'] ?>;" align="center">
                                                    <div align="center" style="color: <?= $entry['explain_color'] ?>">&nbsp;<?= PdfDownloadSelectedAdditionalContent::getPdfTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN] ?>&nbsp;</div>
                                                </td>
                                            <?php else: ?>
                                                <td style="width: 50px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 0px;"></td>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <td style="width: 50px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 0px; background-color: <?= $entry['explain_back_color'] ?>;" align="center">
                                                <div align="center" style="color: <?= $entry['explain_color'] ?>">&nbsp;<?= PdfDownloadSelectedAdditionalContent::getPdfTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN] ?>&nbsp;</div>
                                            </td>
                                            <td style="width: 50px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-top: 0px;"></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </td>
                    <?php endif; ?>
                    <td width="46%" style="padding-left: 5px">

                        <?= $entry['function_name'] ?>
                    </td>
                    <td width="28%" align="right">
                        <label>ja&nbsp;<input type="radio" name="<?= $entry['function_id'] ?>" value="1"></label>&nbsp;&nbsp;&nbsp;
                        <label>nein&nbsp;<input type="radio" name="<?= $entry['function_id'] ?>" value="2"></label>&nbsp;&nbsp;&nbsp;
                        <label>teilweise&nbsp;<input type="radio" name="<?= $entry['function_id'] ?>" value="3"></label>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php $categoryCount++ ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br>
<p>Mit seiner Unterschrift bestätigt der Bieter, dass alle Angaben vollständig und richtig erfolgt ist. Alle Anforderungen, die als erfüllt bestätigt wurden, also mit "ja" beantwortet wurden, müssen bereits zum Zeitpunkt der Angebotsabgabe im angebotenen System funktionsfähig vorhanden sein.</p>
<br>
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td>
            ________________________________,
        </td>
        <td>
            ________________
        </td>
        <td align="right">
            ______________________________________________
        </td>
    </tr>
    <tr>
        <td>
            Ort
        </td>
        <td>
            Datum
        </td>
        <td align="right">
            Firmenstempel + rechtsgültige Unterschrift
        </td>
    </tr>
</table>

