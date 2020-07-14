<?php

namespace backend\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_selected_additional_content".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadSelectedAdditionalContent extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const TYPE_TEST_CRITERIA = 'TEST_CRITERIA';
    const TYPE_EXPLAIN       = 'EXPLAIN';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_selected_additional_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id'], 'required'],
            [['pdf_download_id'], 'integer'],
            [['type'], 'in' , 'range' => [self::TYPE_TEST_CRITERIA, self::TYPE_EXPLAIN]],
            [['type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'created_at'      => Yii::t('app', 'Erstellt am'),
            'updated_at'      => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownload()
    {
        return $this->hasOne(PdfDownload::class, ['id' => 'pdf_download_id']);
    }

    /**
     * return type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_TEST_CRITERIA => Yii::t('app', 'Test-Kriterium'),
            self::TYPE_EXPLAIN       => Yii::t('app', 'Erläutern'),
        ];
    }

    /**
     * return type list
     *
     * @return array
     */
    public static function getPdfTypeList()
    {
        return [
            self::TYPE_TEST_CRITERIA => Yii::t('app', 'Test'),
            self::TYPE_EXPLAIN       => Yii::t('app', 'Info'),
        ];
    }
}
