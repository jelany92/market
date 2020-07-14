<?php
namespace backend\models;

use common\models\Answer;
use common\models\BaseData;
use common\models\CategoryFunctionAnswer;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveRecord;

/**
* This is the model class for table "pdf_download".
 *
 * @property int $id
* @property int $base_data_id
* @property int $answer_to_print
* @property int $show_weighting
* @property int $description_type
*
 * @property BaseData $baseData
*/
class PdfDownload extends ActiveRecord
{
    use TimestampBehaviorTrait;

    const DESCRIPTION_LONG  = 0;
    const DESCRIPTION_SHORT = 1;
    public $arrAnswersToPrint;
    public $additionalContentList;
    public $contentList;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['arrAnswersToPrint', 'contentList','show_weighting', 'description_type'], 'required'],
            [['base_data_id'], 'integer'],
            [['show_weighting'],'boolean'],
            [['base_data_id'], 'unique'],
            [['created_at', 'updated_at','additionalContentList'], 'safe'],
            [['arrAnswersToPrint'], 'exist', 'targetClass' => Answer::class, 'targetAttribute' => 'id', 'allowArray' => true],
            [['base_data_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseData::class, 'targetAttribute' => ['base_data_id' => 'id']],
        ];
    }

    /**
     * Get all Answers that match the models configuration. Same base_data_id and answer that is in $arrAnswersToPrint
     * @return \yii\db\ActiveQuery
     */
    public function getAnswersByConfig()
    {
        return $this->hasMany(CategoryFunctionAnswer::class, ['base_data_id' => 'base_data_id',])->andWhere(['answer_id' => $this->arrAnswersToPrint]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadSelectedAnswer()
    {
        return $this->hasMany(PdfDownloadSelectedAnswer::class, ['pdf_download_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadString()
    {
        return $this->hasMany(PdfDownloadString::class, ['pdf_download_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadContents()
    {
        return $this->hasMany(PdfDownloadContent::class, ['pdf_download_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'base_data_id'          => Yii::t('app', 'Formular Id'),
            'arrAnswersToPrint'     => Yii::t('app', 'Abzubildende Funktionen'),
            'additionalContentList' => Yii::t('app', 'Einstellungen Fragenkatalog'),
            'contentList'           => Yii::t('app', 'Inhalt'),
            'show_weighting'        => Yii::t('app', 'Gewichtungen abbilden'),
            'description_type'      => Yii::t('app', 'Beschreibung'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseData()
    {
        return $this->hasOne(BaseData::class, ['id' => 'base_data_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadAnswerColors()
    {
        return $this->hasMany(PdfDownloadAnswerColor::class, ['pdf_download_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadSelectedAdditionalContents()
    {
        return $this->hasMany(PdfDownloadSelectedAdditionalContent::class, ['pdf_download_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownloadAdditionalContentColors()
    {
        return $this->hasMany(PdfDownloadAdditionalContentColor::class, ['pdf_download_id' => 'id']);
    }




    /**
     * make list for description
     *
     * @return array
     */
    public static function getDescriptionTypes()
    {
        return[
            PdfDownload::DESCRIPTION_SHORT => Yii::t('app', 'kurz'),
            PdfDownload::DESCRIPTION_LONG  => Yii::t('app', 'lang'),
        ];
    }

    /**
     * returns activeQuery for table attachment
     * {@inheritdoc}
     * @return \backend\models\queries\PdfDownloadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\queries\PdfDownloadQuery(get_called_class());
    }
}