<?php

namespace backend\models;

use common\models\Answer;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_selected_answer".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property int $answer_id
 *
 * @property Answer $answer
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadSelectedAnswer extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_selected_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id', 'answer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
}
