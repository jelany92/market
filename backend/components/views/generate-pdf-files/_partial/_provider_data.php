<?php
//Eingabeformular für Daten des Anbieters
use backend\models\PdfDownload;
use backend\components\GeneratePDFFiles;
use backend\models\PdfDownloadSelectedAdditionalContent;
use common\models\Answer;

/* @var $model  \common\models\BaseData */

?>
<h1><?= Yii::t('app', 'Anbieter') ?></h1>
<br>
<br>
<table>
    <tr>
        <td width="150"><h3><?= Yii::t('app', 'Firma') ?>:</h3></td>
        <td colspan="2"><input type="text" name="provider_company" style="width: 83%;"></td>
    </tr>
    <tr>
        <td><h3><?= Yii::t('app', 'Straße, Nr.') ?>:</h3></td>
        <td colspan="2"><input type="text" name="provider_contact_street" style="width: 83%;"></td>
    </tr>
    <tr>
        <td><h3><?= Yii::t('app', 'Land') ?>:</h3></td>
        <td colspan="2"><input type="text" name="provider_contact_country" style="width: 83%;"></td>
    </tr>
    <tr>
        <td width="150"><h3><?= Yii::t('app', 'PLZ Ort') ?>:</h3></td>
        <td><input type="text" name="provider_contact_plz" style="width: 90px;"></td>
        <td><input type="text" name="provider_contact_city" style="width: 415px"></td>
    </tr>
</table>
<br>
<br>
<h2><?= Yii::t('app', 'Ansprechpartner') ?></h2>
<table>
    <tr>
        <td></td>
        <td>
            <label><input type="radio" name="provider_contact_gender" value="1">&nbsp;<?= Yii::t('app', 'Herr') ?></label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="provider_contact_gender" value="2">&nbsp;<?= Yii::t('app', 'Frau') ?></label>
        </td>
    </tr>
    <tr>
        <td width="150"><h3><?= Yii::t('app', 'Name, Vorname') ?>:</h3></td>
        <td colspan="3"><input type="text" name="provider_contact_first_name" style="width: 83%;"></td>
    </tr>
    <tr>
        <td><h3><?= Yii::t('app', 'E-Mail') ?>:</h3></td>
        <td colspan="3"><input type="text" name="provider_contact_mail" style="width: 83%;"></td>
    </tr>

    <tr>
        <td width="150"><h3><?= Yii::t('app', 'Telefon') ?>:</h3></td>
        <td><input type="text" name="provider_contact_phone_country_pre" style="width: 93px"></td>
        <td><input type="text" name="provider_contact_phone_pre" style="width: 190px"></td>
        <td><input type="text" name="provider_contact_phone" style="width: 200px"></td>
    </tr>
    <tr>
        <td><h3><?= Yii::t('app', 'Mobil') ?>:</h3></td>
        <td><input type="text" name="provider_contact_mobile_country_pre" style="width: 93px"></td>
        <td><input type="text" name="provider_contact_mobile_pre" style="width: 190px"></td>
        <td><input type="text" name="provider_contact_mobile" style="width: 200px"></td>
    </tr>
</table>

<br>
<br>
<h3>Bearbeitungshinweise:</h3>
<p>Dieses Dokument nutzen Sie im Zusammenhang mit der ausführlichen Funktionsbeschreibung. Jede Funktion hat in der linken Spalte eine 4-stellige Ordnungsnummer. Die erste Ziffer beschreibt den Themenbereich, die 3 Ziffern nach dem Punkt geben die Funktionsnummern. Die genaue Beschreibung der
    geforderten Funktion finden Sie in der Funktionsbeschreibung.</p>
<p>Kreuzen Sie in der nachfolgenden Tabelle für jede Funktion an, ob Ihr System die Funktion erfüllt, nicht erfüllt oder nur teilweise erfüllt. Falls Ihr System die Funktion nur teilweise erfüllt beschreiben Sie Ihre Funktion in einem Beilblatt zum Angebot und geben dabei genau wann, welche
    Teile der Anforderungen nicht erfüllt werden.</p>
<?php
$pdfDownload = PdfDownload::find()->andWhere(['base_data_id' => $model->id])->one();
if ($pdfDownload->show_weighting) : ?>
    <p>In der zweiten Spalte ist jede Funktion gewichtet.</p>
    <?php
    $answer5 = GeneratePDFFiles::getAnswerColorByAnswerId($model, Answer::NAME_K_O);
    if ($answer5): ?>
        <p><span style="color: <?= $answer5['color'] ?>; background-color: <?= $answer5['back_color'] ?>"><?= $answer5['name'] ?></span> bedeutet, dass diese Funktionen erfüllt werden müssen. Andernfalls wird das Angebot des Bieters ausgeschlossen, weil Anforderungen von zentraler Bedeutung nicht
            erfüllt werden können.</P>
    <? endif; ?>
    <?php
    $answer4 = GeneratePDFFiles::getAnswerColorByAnswerId($model, Answer::NAME_IMPORTANT);
    $answer3 = GeneratePDFFiles::getAnswerColorByAnswerId($model, Answer::NAME_LATER_IMPORTANT);
    if ($answer3 || $answer4): ?>
        <p>Anforderungen, die mit
            <?php if ($answer4): ?>
                <span style="color: <?= $answer4['color'] ?>; background-color: <?= $answer4['back_color'] ?>"><?= $answer4['name'] ?></span>
                <?php if ($answer3): ?>
                    oder
                    <span style="color: <?= $answer3['color'] ?>; background-color: <?= $answer3['back_color'] ?>"><?= $answer3['name'] ?></span>
                <?php endif; ?>
            <?php else: ?>
                <span style="color: <?= $answer3['color'] ?>; background-color: <?= $answer3['back_color'] ?>"><?= $answer3['name'] ?></span>
            <?php endif; ?>
            klassifiziert sind, jedoch nicht oder nur teilweise erfüllt werden, werden im Vergleich zu anderen Systemen bewertet.</p>
    <?php endif; ?>
    <?php
    $contentExplain = GeneratePDFFiles::getAdditionalContentColorByType($model, PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN);
    $contentTest    = GeneratePDFFiles::getAdditionalContentColorByType($model, PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA);
    if ($contentExplain): ?>
        <p>Funktionen die mit <span style="color:<?= $contentExplain['color'] ?>; background-color:<?= $contentExplain['back_color'] ?>"><?= PdfDownloadSelectedAdditionalContent::getPdfTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN] ?></span> klassifiziert sind, müssen auf einem extra
            Blatt detailliert erläutert werden.</p>
    <?php endif;
    if ($contentTest): ?>
        <p>Funktionen die mit <span style="color:<?= $contentTest['color'] ?>;background-color:<?= $contentTest['back_color'] ?>"><?= PdfDownloadSelectedAdditionalContent::getPdfTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA] ?></span> klassifiziert sind, müssen in einem
            Testsystem zur Verfügung stehen.</p>
    <? endif; ?>

    <p>Es bleibt dem Auftraggeber vorenthalten, Funktionen im Rahmen einer kostenlosen Teststellung des Systems zu überprüfen. Alle Anforderungen, die mit "ja" markiert werden, also als erfüllt bestätigt werden, müssen bereits zum Zeitpunkt der Angebotsabgabe vorhanden sein.</p>

<? endif; ?>

