<?php

namespace common\models;

use backend\models\Attachment;
use backend\models\PdfDownload;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "base_data".
 *
 * @property int    $id
 * @property string $code
 * @property string $public_key
 * @property string $company_name
 * @property int    $company_type_id
 * @property string $street
 * @property string $house_number
 * @property string $zip_code
 * @property string $city
 * @property int    $country_id
 * @property string $salutation
 * @property string $first_name
 * @property string $last_name
 * @property string $base_date
 * @property string $application_trainee_count
 * @property string $application_dual_students_count
 * @property string $application_assistants_count
 * @property string $application_executives_count
 * @property string $vacancy_trainee_count
 * @property string $vacancy_dual_students_count
 * @property string $vacancy_assistants_count
 * @property string $vacancy_executives_count
 * @property string $admin_count
 * @property string $person_responsible_count
 * @property string $evaluator_count
 * @property string $executives_count
 * @property string $employee_count
 * @property string $location_count
 * @property string $location_names
 * @property string $company_count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attachment[]                $attachments
 * @property CompanyType                 $companyType
 * @property Country                     $country
 * @property BaseDataCondition[]         $baseDataConditions
 * @property Condition[]                 $conditions
 * @property CategoryFunctionAnswer[]    $categoryFunctionAnswers
 * @property FunctionRestrictToProject[] $functionRestrictToProjects
 * @property PdfDownload                 $pdfDownload
 */
class BaseData extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const SALUTATION_SIR    = 'herr';
    const SALUTATION_MRS    = 'frau';
    const NUMBER_ZERO_FALSE = 0;
    const NUMBER_ONE_TRUE   = 1;

    public $companyCountSelection;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'company_name', 'street', 'city', 'house_number', 'zip_code', 'code'], 'trim'],
            [['code'], 'filter', 'filter'=>'strtoupper'],
            [['company_name', 'company_type_id'], 'required'],
            [['country_id', 'company_type_id'],'integer'],
            [['company_count'], 'integer', 'min' => 1, 'when' => function ($model) {
                return $model->companyCountSelection == BaseData::NUMBER_ONE_TRUE;
            }],
            [['application_trainee_count', 'application_dual_students_count', 'application_assistants_count', 'application_executives_count', 'vacancy_trainee_count', 'vacancy_dual_students_count', 'vacancy_assistants_count', 'vacancy_executives_count', 'admin_count', 'person_responsible_count', 'evaluator_count','executives_count', 'employee_count', 'location_count', 'company_count'], 'integer', 'min' => 0],
            [['country_id'],  'exist', 'targetClass' => Country::class, 'targetAttribute' => 'id'],
            [['company_type_id'],  'exist', 'targetClass' => CompanyType::class, 'targetAttribute' => 'id'],
            [['salutation'], 'in' , 'range' => [self::SALUTATION_SIR, self::SALUTATION_MRS]],
            [['base_date'], 'date', 'format' => 'php:d.m.Y', 'max'=>date('d.m.Y', strtotime('+1 year'))],
            [['company_name', 'location_names'], 'string', 'max' => 255],
            [['public_key','street', 'city', 'first_name', 'last_name'], 'string', 'max' => 50],
            [['house_number', 'zip_code', 'code'], 'string', 'max' => 10],
            [['code'], 'unique'],
            [['public_key'], 'unique'],
            [['base_date', 'created_at', 'updated_at','companyCountSelection'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                              => Yii::t('app', 'ID'),
            'code'                            => Yii::t('app', 'Projekt-Code'),
            'public_key'                      => Yii::t('app', 'Public Key'),
            'company_name'                    => Yii::t('app', 'Auftraggeber'),
            'company_type_id'                 => Yii::t('app', 'Art des Auftraggebers'),
            'street'                          => Yii::t('app', 'Straße'),
            'house_number'                    => Yii::t('app', 'Hausnummer'),
            'zip_code'                        => Yii::t('app', 'PLZ'),
            'city'                            => Yii::t('app', 'Ort'),
            'country_id'                      => Yii::t('app', 'Land'),
            'salutation'                      => Yii::t('app', 'Anrede'),
            'first_name'                      => Yii::t('app', 'Vorname'),
            'last_name'                       => Yii::t('app', 'Nachname'),
            'base_date'                       => Yii::t('app', 'Datum'),
            'application_trainee_count'       => Yii::t('app', 'Anzahl Bewerbungen Azubis'),
            'application_dual_students_count' => Yii::t('app', 'Anzahl Bewerbungen Duale Studenten'),
            'application_assistants_count'    => Yii::t('app', 'Anzahl Bewerbungen Hilfskräfte'),
            'application_executives_count'    => Yii::t('app', 'Anzahl Bewerbungen Fach- und Führungskräfte'),
            'vacancy_trainee_count'           => Yii::t('app', 'Anzahl Stellenausschreibungen Azubis'),
            'vacancy_dual_students_count'     => Yii::t('app', 'Anzahl Stellenausschreibungen Duale Studenten'),
            'vacancy_assistants_count'        => Yii::t('app', 'Anzahl Stellenausschreibungen Hilfskräfte'),
            'vacancy_executives_count'        => Yii::t('app', 'Anzahl Stellenausschreibungen Fach- und Führungskräfte'),
            'admin_count'                     => Yii::t('app', 'Accounts Fachadministatoren'),
            'person_responsible_count'        => Yii::t('app', 'Accounts Personalsachbearbeiter'),
            'evaluator_count'                 => Yii::t('app', 'Accounts Bewerter und Gremien'),
            'executives_count'                => Yii::t('app', 'Accounts Fach- und Führungskräfte'),
            'employee_count'                  => Yii::t('app', 'Anzahl der Mitarbeiter'),
            'location_count'                  => Yii::t('app', 'Anzahl weitere Standorte'),
            'location_names'                  => Yii::t('app', 'Bezeichnung der Standorte'),
            'company_count'                   => Yii::t('app', 'Anzahl der Unternehmen'),
            'companyCountSelection'           => Yii::t('app', 'Unternehmensgruppe'),
            'created_at'                      => Yii::t('app', 'Erstellt am'),
            'updated_at'                      => Yii::t('app', 'Bearbeitet am'),
        ];
    }

    /**
     * Relation to Address Country
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFunctionAnswers()
    {
        return $this->hasMany(CategoryFunctionAnswer::class, ['base_data_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasMany(Attachment::class, ['base_data_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownload()
    {
        return $this->hasOne(PdfDownload::class, ['base_data_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyType()
    {
        return $this->hasOne(CompanyType::class, ['id' => 'company_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionRestrictToProjects()
    {
        return $this->hasMany(FunctionRestrictToProject::class, ['base_data_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDataConditions()
    {
        return $this->hasMany(BaseDataCondition::class, ['base_data_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConditions()
    {
        return $this->hasMany(Condition::class, ['id' => 'condition_id'])
                    ->orderBy(['name' => SORT_ASC])
                    ->via('baseDataConditions');
    }


    /**
     * make list for salutation
     *
     * @return array
     */
    public static function getSalutationList()
    {
        return [
            self::SALUTATION_SIR => Yii::t('app', 'Herr'),
            self::SALUTATION_MRS => Yii::t('app', 'Frau'),
        ];
    }

    /**
     * make list for boolean yes or no
     *
     * @return array
     */
    public static function getBooleanList()
    {
        return $boolean = [
            BaseData::NUMBER_ONE_TRUE   => 'Ja',
            BaseData::NUMBER_ZERO_FALSE => 'Nein',
        ];
    }

    /**
     * Returns an ordered List of base data ids and company names
     *
     * @return array
     */
    public static function getNameList()
    {
        return ArrayHelper::map(BaseData::find()->orderBy(['company_name' => SORT_ASC])->all(), 'id', 'company_name');
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
        {
            return false;
        }
        $baseDateTime = \DateTime::createFromFormat('d.m.Y', $this->base_date);

        if ($baseDateTime instanceof \DateTime)
        {
            $this->base_date = $baseDateTime->format('Y-m-d');
        }
        else
        {
            $this->base_date = null;
        }

        return true;
    }

    /**
     * Generates link to documents frontend
     *
     * @return string
     */
    public function getFunctionLink()
    {
        return Yii::$app->urlManagerFrontend->createUrl(['/project/details', 'key' => $this->public_key, ]);
    }
}
