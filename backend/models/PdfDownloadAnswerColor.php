<?php

namespace backend\models;

use common\models\Answer;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_answer_color".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property int $answer_id
 * @property string $color
 * @property string $back_color
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Answer $answer
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadAnswerColor extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    const UNSIGNED_MEDIUM_INT_MIN  = 0;
    const UNSIGNED_MEDIUM_INT_MAX = 16777215;
    const STANDARD_BACK_COLOR = "#696969";
    const STANDARD_COLOR = "#ffffff";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_answer_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id', 'answer_id'], 'integer'],
            [['color', 'back_color'], 'match', 'pattern' => '/\#[a-fA-F0-9]{6}$/'],
            [['created_at', 'updated_at'], 'safe'],
            [['pdf_download_id', 'answer_id'], 'unique', 'targetAttribute' => ['pdf_download_id', 'answer_id']],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['pdf_download_id'], 'exist', 'skipOnError' => true, 'targetClass' => PdfDownload::class, 'targetAttribute' => ['pdf_download_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pdf_download_id' => Yii::t('app', 'Pdf Download ID'),
            'answer_id' => Yii::t('app', 'Answer ID'),
            'color' => Yii::t('app', 'Color'),
            'back_color' => Yii::t('app', 'Back Color'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::class, ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownload()
    {
        return $this->hasOne(PdfDownload::class, ['id' => 'pdf_download_id']);
    }

    /**
     * @param $arrAnswers
     *
     * @return array
     */
    public static function createStandardArray($arrAnswers)
    {
        $arrPdfDownloadAnswerColor = [];
        if(is_array($arrAnswers))
        {
            foreach ($arrAnswers as $answerId => $answerName)
            {
                $arrPdfDownloadAnswerColor[$answerId]['color']      = self::STANDARD_COLOR;
                $arrPdfDownloadAnswerColor[$answerId]['back_color'] = self::STANDARD_BACK_COLOR;
            }
        }
        return $arrPdfDownloadAnswerColor;
    }

    /**
     * Helper function to make sure that the number and ids of each pdf_download_answer_color match up with the number and ids of category_function_answers in existence
     *
     * @param $arrAnswerColors array Needs to be an array with answer_id as id!!!
     * @param $arrPossibleAnswers array
     *
     * @return bool
     */
    public static function compareAnswerColorsIndexedByAnswerIdArraysToExistingAnswers($arrAnswerColors, $arrPossibleAnswers)
    {
        return (count( $arrAnswerColors) == count( $arrPossibleAnswers ) && !array_diff( array_keys($arrAnswerColors), array_keys($arrPossibleAnswers)));
    }

    /**
     * Checks if saving colors is necessary or not
     *
     * @param $pdfDownloadId
     * @param $arrAnswerColors
     * @param $arrAnswerColorsBack
     *
     * @return bool
     */
    public static function checkIfColorsChanged($pdfDownloadId, $arrAnswerColors, $arrAnswerColorsBack)
    {
        $output = false;
        $oldPdfDownloadAnswerColors = self::find()->andWhere(['pdf_download_id' => $pdfDownloadId])->all();
        if(is_array($oldPdfDownloadAnswerColors) && count($oldPdfDownloadAnswerColors) == count($arrAnswerColors) && count($oldPdfDownloadAnswerColors) == count($arrAnswerColorsBack))
        {
            //If number of colors is unchanged, check all colors and see if at least one has changed
            foreach ($oldPdfDownloadAnswerColors as $key => $objAnswerColor)
            {
                /* @var $objAnswerColor PdfDownloadAnswerColor */
                if ($objAnswerColor->color != $arrAnswerColors[$objAnswerColor->answer_id] || $objAnswerColor->back_color != $arrAnswerColorsBack[$objAnswerColor->answer_id])
                {
                    $output = true;
                    break;
                }
            }
        }
        else
        {
            //If number of colors has changed, immidietely set output true
            $output = true;
        }
        return $output;
    }
}
