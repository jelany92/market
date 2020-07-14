<?php

namespace backend\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_additional_content_color".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property string $type
 * @property string $color
 * @property string $back_color
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadAdditionalContentColor extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_additional_content_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id', 'color', 'back_color'], 'required'],
            [['pdf_download_id'], 'integer'],
            [['color', 'back_color'], 'match', 'pattern' => '/\#[a-fA-F0-9]{6}$/'],
            [['type'], 'string'],
            [['type'], 'in' , 'range' => [PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA, PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN]],
            [['created_at', 'updated_at'], 'safe'],
            [['color', 'back_color'], 'string', 'max' => 7],
            [['pdf_download_id'], 'exist', 'skipOnError' => true, 'targetClass' => PdfDownload::class, 'targetAttribute' => ['pdf_download_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'pdf_download_id' => Yii::t('app', 'Pdf Download ID'),
            'type'            => Yii::t('app', 'Type'),
            'color'           => Yii::t('app', 'Color'),
            'back_color'      => Yii::t('app', 'Back Color'),
            'created_at'      => Yii::t('app', 'Erstellt am'),
            'updated_at'      => Yii::t('app', 'Aktualisiert am'),
        ];
    }


    /**
     * @param $arrAnswers
     *
     * @return array
     */
    public static function createStandardArray()
    {
        $arrPdfDownloadColor = [];
        $list = PdfDownloadSelectedAdditionalContent::getTypeList();
        foreach ($list as $key => $value)
        {
            $arrPdfDownloadColor[$key]['color']      = PdfDownloadAnswerColor::STANDARD_COLOR;
            $arrPdfDownloadColor[$key]['back_color'] = PdfDownloadAnswerColor::STANDARD_BACK_COLOR;

        }
        return $arrPdfDownloadColor;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownload()
    {
        return $this->hasOne(PdfDownload::class, ['id' => 'pdf_download_id']);
    }
}
