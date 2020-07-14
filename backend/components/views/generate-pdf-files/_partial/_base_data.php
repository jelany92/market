<?php
//Kontaktdaten


use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BaseData */

?>

<div class="base-data-view">
    <h1><?= Html::encode('Auftraggeber') ?></h1>
    <table class="base_data_table">
        <tr>
            <th><?= Yii::t('app', 'Firma, Behörde, Institution') ?></th>
            <td><?= $model['company_name'] ?></td>
        </tr>
        <tr>
            <?php if (isset($model['country_id'])) : ?>
                <th><?= Yii::t('app', 'Ansprechpartner') ?></th>
                <td><?= $model->salutationList[$model['salutation']] . ' ' . $model['first_name'] . ' ' . $model['last_name'] ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['street'])) : ?>
                <th><?= Yii::t('app', 'Straße, Hausnummer') ?></th>
                <td><?= $model['street'] . ' ' . $model['house_number'] ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['zip_code']) || (isset($model['city']))) : ?>
                <th><?= Yii::t('app', 'PLZ, Ort') ?></th>
                <td><?= (isset($model['zip_code']) ? $model['zip_code'] . ' ' : '') . (isset($model['city']) ? $model['city'] . '' : '') ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['country_id'])) : ?>
                <th><?= Yii::t('app', 'Land') ?></th>
                <td><?= $model->countryList[$model['country_id']] ?></td>
            <?php endif; ?>
        </tr>
    </table>
    <?php //count variable ?>
    <h1><?= Yii::t('app', 'Details zum Projekt') ?></h1>

    <?php if (isset($model['vacancy_trainee_count']) || isset($model['vacancy_dual_students_count']) || isset($model['vacancy_executives_count'])) : ?>
        <h3><?= Yii::t('app', 'Stellenausschreibungen pro Jahr') ?></h3>
    <?php endif; ?>

    <table class="base_data_table">
        <tr>
            <?php if (isset($model['vacancy_trainee_count'])) : ?>
                <th><?= Yii::t('app', 'Auszubildende') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['vacancy_trainee_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['vacancy_dual_students_count'])) : ?>
                <th><?= Yii::t('app', 'Duale Studenten') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['vacancy_dual_students_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['vacancy_assistants_count'])) : ?>
                <th><?= Yii::t('app', 'Hilfskräfte') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['vacancy_assistants_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['vacancy_executives_count'])) : ?>
                <th><?= Yii::t('app', 'Fach- und Führungskräfte') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['vacancy_executives_count']) ?></td>
            <?php endif; ?>
        </tr>
    </table>

    <?php if (isset($model['application_trainee_count']) || isset($model['application_dual_students_count']) || isset($model['application_executives_count'])) : ?>
        <h3><?= Yii::t('app', 'Bewerbungen pro Jahr') ?></h3>
    <?php endif; ?>

    <table class="base_data_table">
        <tr>
            <?php if (isset($model['application_trainee_count'])) : ?>
                <th><?= Yii::t('app', 'Auszubildende') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['application_trainee_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['application_dual_students_count'])) : ?>
                <th><?= Yii::t('app', 'Duale Studenten') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['application_dual_students_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['application_assistants_count'])) : ?>
                <th><?= Yii::t('app', 'Hilfskräfte') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['application_assistants_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['application_executives_count'])) : ?>
                <th><?= Yii::t('app', 'Fach- und Führungskräfte') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['application_executives_count']) ?></td>
            <?php endif; ?>
        </tr>
    </table>

    <?php if (isset($model['admin_count']) || isset($model['person_responsible_count']) || isset($model['evaluator_count'])) : ?>
        <h3><?= Yii::t('app', 'Accounts') ?></h3>
    <?php endif; ?>

    <table class="base_data_table">
        <tr>
            <?php if (isset($model['admin_count'])) : ?>
                <th><?= Yii::t('app', 'Fachadministatoren') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['admin_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['person_responsible_count'])) : ?>
                <th><?= Yii::t('app', 'Personalsachbearbeiter') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['person_responsible_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['executives_count'])) : ?>
                <th><?= Yii::t('app', 'Gremien') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['executives_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['evaluator_count'])) : ?>
                <th><?= Yii::t('app', 'Bewerter und Gremien') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['evaluator_count']) ?></td>
            <?php endif; ?>
        </tr>
    </table>

    <?php if (isset($model['employee_count']) || isset($model['location_count']) || (isset($model['company_count']) && 1 < $model['company_count'])) : ?>
        <h3><?= $model->company_count > 1 ? Yii::t('app', 'Angaben zur Firmengruppe') : Yii::t('app', 'Angaben zum Unternehmen') ?></h3>
    <?php endif; ?>

    <table class="base_data_table">
        <tr>
            <?php if (isset($model['employee_count'])) : ?>
                <th><?= Yii::t('app', 'Mitarbeiter') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['employee_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['location_count'])) : ?>
                <th><?= Yii::t('app', 'Standorte') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['location_count']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['location_names'])) : ?>
                <th><?= Yii::t('app', 'Bezeichnung der Standorte') ?></th>
                <td><?= Yii::$app->formatter->asText($model['location_names']) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($model['company_count']) && 1 < $model['company_count']) : ?>
                <th><?= Yii::t('app', 'Unternehmen') ?></th>
                <td><?= Yii::$app->formatter->asInteger($model['company_count']) ?></td>
            <?php endif; ?>
        </tr>
    </table>
</div>
<br>
