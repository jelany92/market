<?php

namespace common\models;

use DateTime;
use Yii;
use yii\base\Model;

/**
 * Class BaseDataForm
 *
 * @property BaseData $baseData
 * @property int      $id
 * @property string   $code
 * @property string   $companyName
 * @property int      $companyTypeId
 * @property string   $street
 * @property string   $houseNumber
 * @property string   $zipCode
 * @property string   $city
 * @property int      $countryId
 * @property string   $salutation
 * @property string   $firstName
 * @property string   $lastName
 * @property string   $baseDate
 * @property string   $applicationTraineeCount
 * @property string   $applicationDualStudentsCount
 * @property string   $applicationAssistantsCount
 * @property string   $applicationExecutivesCount
 * @property string   $vacancyTraineeCount
 * @property string   $vacancyDualStudentsCount
 * @property string   $vacancyAssistantsCount
 * @property string   $vacancyExecutivesCount
 * @property string   $adminCount
 * @property string   $personResponsibleCount
 * @property string   $evaluatorCount
 * @property string   $executivesCount
 * @property string   $employeeCount
 * @property string   $locationCount
 * @property string   $locationNames
 * @property string   $companyCount
 * @property string   $companyCountSelection
 *
 * @property array    $conditions
 */
class BaseDataForm extends Model
{

    public $baseData;
    public $id;
    public $code;
    public $companyName;
    public $companyTypeId;
    public $street;
    public $houseNumber;
    public $zipCode;
    public $city;
    public $countryId;
    public $salutation;
    public $firstName;
    public $lastName;
    public $baseDate;
    public $applicationTraineeCount;
    public $applicationDualStudentsCount;
    public $applicationAssistantsCount;
    public $applicationExecutivesCount;
    public $vacancyTraineeCount;
    public $vacancyDualStudentsCount;
    public $vacancyAssistantsCount;
    public $vacancyExecutivesCount;
    public $adminCount;
    public $personResponsibleCount;
    public $evaluatorCount;
    public $executivesCount;
    public $employeeCount;
    public $locationCount;
    public $locationNames;
    public $companyCount;
    public $companyCountSelection = BaseData::NUMBER_ZERO_FALSE;
    public $conditionList = [];


    public function __construct(BaseData $baseData = null)
    {
        parent::__construct([]);

        if ($baseData instanceof BaseData)
        {
            $this->baseData                     = $baseData;
            $this->id                           = $baseData->id;
            $this->code                         = $baseData->code;
            $this->companyName                  = $baseData->company_name;
            $this->companyTypeId                = $baseData->company_type_id;
            $this->street                       = $baseData->street;
            $this->houseNumber                  = $baseData->house_number;
            $this->zipCode                      = $baseData->zip_code;
            $this->city                         = $baseData->city;
            $this->countryId                    = $baseData->country_id;
            $this->salutation                   = $baseData->salutation;
            $this->firstName                    = $baseData->first_name;
            $this->lastName                     = $baseData->last_name;
            $this->baseDate                     = $baseData->base_date;
            $this->applicationTraineeCount      = $baseData->application_trainee_count;
            $this->applicationDualStudentsCount = $baseData->application_dual_students_count;
            $this->applicationAssistantsCount   = $baseData->application_assistants_count;
            $this->applicationExecutivesCount   = $baseData->application_executives_count;
            $this->vacancyTraineeCount          = $baseData->vacancy_trainee_count;
            $this->vacancyDualStudentsCount     = $baseData->vacancy_dual_students_count;
            $this->vacancyAssistantsCount       = $baseData->vacancy_assistants_count;
            $this->vacancyExecutivesCount       = $baseData->vacancy_executives_count;
            $this->adminCount                   = $baseData->admin_count;
            $this->personResponsibleCount       = $baseData->person_responsible_count;
            $this->evaluatorCount               = $baseData->evaluator_count;
            $this->executivesCount              = $baseData->executives_count;
            $this->employeeCount                = $baseData->employee_count;
            $this->locationCount                = $baseData->location_count;
            $this->locationNames                = $baseData->location_names;
            $this->companyCount                 = $baseData->company_count;
            foreach ($baseData->conditions AS $condition)
            {
                $this->conditionList[] = $condition->id;
            }

            $this->companyCountSelection = BaseData::NUMBER_ONE_TRUE;
            if ($this->companyCount == 1)
            {
                $this->companyCount          = null;
                $this->companyCountSelection = BaseData::NUMBER_ZERO_FALSE;
            }
            if (!is_null($this->baseDate))
            {
                $baseDate       = new DateTime($this->baseDate);
                $this->baseDate = $baseDate->format('d.m.Y');
            }

        }
    }

    /**
     * {@inheritdoc}
     */
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'companyName', 'street', 'city', 'houseNumber', 'zipCode', 'code'], 'trim'],
            [['code'], 'filter', 'filter' => 'strtoupper'],
            [['companyName', 'companyTypeId'], 'required'],
            [['countryId', 'companyTypeId'],'integer'],
            [['companyCount'], 'integer', 'min' => 1, 'when' => function ($model) {
                return $model->companyCountSelection == BaseData::NUMBER_ONE_TRUE;
            }],
            [['conditionList'], 'each', 'rule' => ['exist', 'skipOnError' => true, 'targetClass' => Condition::class, 'targetAttribute' => 'id']],
            [['applicationTraineeCount', 'applicationDualStudentsCount', 'applicationAssistantsCount', 'applicationExecutivesCount', 'vacancyTraineeCount', 'vacancyDualStudentsCount', 'vacancyAssistantsCount', 'vacancyExecutivesCount', 'adminCount', 'personResponsibleCount', 'evaluatorCount','executivesCount', 'employeeCount', 'locationCount', 'companyCount'], 'integer', 'min' => 0],
            [['countryId'],  'exist', 'targetClass' => Country::class, 'targetAttribute' => 'id'],
            [['companyTypeId'],  'exist', 'targetClass' => CompanyType::class, 'targetAttribute' => 'id'],
            [['salutation'], 'in' , 'range' => [BaseData::SALUTATION_SIR, BaseData::SALUTATION_MRS]],
            [['baseDate'], 'date', 'format' => 'php:d.m.Y', 'max'=>date('d.m.Y', strtotime('+1 year'))],
            [['companyName', 'locationNames'], 'string', 'max' => 255],
            [['street', 'city', 'firstName', 'lastName'], 'string', 'max' => 50],
            [['houseNumber', 'zipCode', 'code'], 'string', 'max' => 10],
            [['code'], 'unique', 'targetClass' => BaseData::class, 'targetAttribute' => 'code', 'filter' => function ($query) {
                if ($this->baseData instanceof BaseData) {
                    $query->andWhere(['not', ['id'=>$this->baseData->id]]);
                }
            }],
            [['baseDate', 'companyCountSelection'], 'safe'],
        ];
    }

    /**
     * Copy values from Form model to Active Record and creates/updates Entry in database
     *
     * @return bool|BaseData
     * @throws \yii\base\Exception
     */
    public function saveBaseData(){
        if($this->baseData instanceof BaseData){
            $model = $this->baseData;
        }else{
            $model = new BaseData();
            do
            {
                $model->public_key = Yii::$app->security->generateRandomString(50);
            } while (!$model->validate(['public_key']));
        }

        // Wenn keine Unternehmsgruppe, setze die Anzahl der Unternehmen auf den Wert 1
        if ($this->companyCountSelection == BaseData::NUMBER_ZERO_FALSE)
        {
            $this->companyCount = BaseData::NUMBER_ONE_TRUE;
        }

        $model->code                            = $this->code;
        $model->company_name                    = $this->companyName;
        $model->company_type_id                 = $this->companyTypeId;
        $model->street                          = $this->street;
        $model->house_number                    = $this->houseNumber;
        $model->zip_code                        = $this->zipCode;
        $model->city                            = $this->city;
        $model->country_id                      = $this->countryId;
        $model->salutation                      = $this->salutation;
        $model->first_name                      = $this->firstName;
        $model->last_name                       = $this->lastName;
        $model->base_date                       = $this->baseDate;
        $model->application_trainee_count       = $this->applicationTraineeCount;
        $model->application_dual_students_count = $this->applicationDualStudentsCount;
        $model->application_assistants_count    = $this->applicationAssistantsCount;
        $model->application_executives_count    = $this->applicationExecutivesCount;
        $model->vacancy_trainee_count           = $this->vacancyTraineeCount;
        $model->vacancy_dual_students_count     = $this->vacancyDualStudentsCount;
        $model->vacancy_assistants_count        = $this->vacancyAssistantsCount;
        $model->vacancy_executives_count        = $this->vacancyExecutivesCount;
        $model->admin_count                     = $this->adminCount;
        $model->person_responsible_count        = $this->personResponsibleCount;
        $model->evaluator_count                 = $this->evaluatorCount;
        $model->executives_count                = $this->executivesCount;
        $model->employee_count                  = $this->employeeCount;
        $model->location_count                  = $this->locationCount;
        $model->location_names                  = $this->locationNames;
        $model->company_count                   = $this->companyCount;


        if ($model->save())
        {
            // Delete all old relations
            BaseDataCondition::deleteAll(['base_data_id' => $model->id]);
            // Save Relations
            if (is_array($this->conditionList) && 0 < count($this->conditionList))
            {
                foreach ($this->conditionList AS $conditionId)
                {
                    $relation               = new BaseDataCondition();
                    $relation->condition_id = $conditionId;
                    $relation->base_data_id = $model->id;
                    $relation->save();
                }
            }
            return $model;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code'                         => Yii::t('app', 'Projekt-Code'),
            'companyName'                  => Yii::t('app', 'Auftraggeber'),
            'companyTypeId'                => Yii::t('app', 'Art des Auftraggebers'),
            'street'                       => Yii::t('app', 'Straße'),
            'houseNumber'                  => Yii::t('app', 'Hausnummer'),
            'zipCode'                      => Yii::t('app', 'PLZ'),
            'city'                         => Yii::t('app', 'Ort'),
            'countryId'                    => Yii::t('app', 'Land'),
            'salutation'                   => Yii::t('app', 'Anrede'),
            'firstName'                    => Yii::t('app', 'Vorname'),
            'lastName'                     => Yii::t('app', 'Nachname'),
            'baseDate'                     => Yii::t('app', 'Datum'),
            'applicationTraineeCount'      => Yii::t('app', 'Anzahl Bewerbungen Azubis'),
            'applicationDualStudentsCount' => Yii::t('app', 'Anzahl Bewerbungen Duale Studenten'),
            'applicationAssistantsCount'   => Yii::t('app', 'Anzahl Bewerbungen Hilfskräfte'),
            'applicationExecutivesCount'   => Yii::t('app', 'Anzahl Bewerbungen Fach- und Führungskräfte'),
            'vacancyTraineeCount'          => Yii::t('app', 'Anzahl Stellenausschreibungen Azubis'),
            'vacancyDualStudentsCount'     => Yii::t('app', 'Anzahl Stellenausschreibungen Duale Studenten'),
            'vacancyAssistantsCount'       => Yii::t('app', 'Anzahl Stellenausschreibungen Hilfskräfte'),
            'vacancyExecutivesCount'       => Yii::t('app', 'Anzahl Stellenausschreibungen Fach- und Führungskräfte'),
            'adminCount'                   => Yii::t('app', 'Accounts Fachadministatoren'),
            'personResponsibleCount'       => Yii::t('app', 'Accounts Personalsachbearbeiter'),
            'evaluatorCount'               => Yii::t('app', 'Accounts Bewerter und Gremien'),
            'executivesCount'              => Yii::t('app', 'Accounts Fach- und Führungskräfte'),
            'employeeCount'                => Yii::t('app', 'Anzahl der Mitarbeiter'),
            'locationCount'                => Yii::t('app', 'Anzahl weitere Standorte'),
            'locationNames'                => Yii::t('app', 'Bezeichnung der Standorte'),
            'companyCount'                 => Yii::t('app', 'Anzahl der Unternehmen'),
            'companyCountSelection'        => Yii::t('app', 'Unternehmensgruppe'),
            'conditionList'                => Yii::t('app', 'Rahmenbedingungen'),
        ];
    }

}
