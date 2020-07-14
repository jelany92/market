<?php

namespace backend\models;

use backend\models\queries\PdfDownloadStringQuery;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_string".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property string $type
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadString extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    const TYPE_HEADER = 'header';
    const TYPE_FOOTER = 'footer';
    const CONTENT_LENGTH = [
      self::TYPE_FOOTER => 25,
      self::TYPE_HEADER => 65,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_string';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id', 'type'], 'required'],
            [['pdf_download_id'], 'integer'],
            [['type'], 'in', 'range' => [self::TYPE_HEADER, self::TYPE_FOOTER]],
            [['created_at', 'updated_at'], 'safe'],
            //[['content'], 'string', 'max' => self::MAX_CONTENT_LENGTH],
            [['content'], 'checkStringlengthBasedOnType'],
            [['pdf_download_id', 'type'], 'unique', 'targetAttribute' => ['pdf_download_id', 'type']],
            [['pdf_download_id'], 'exist', 'skipOnError' => true, 'targetClass' => PdfDownload::class, 'targetAttribute' => ['pdf_download_id' => 'id']],
        ];
    }

    public function checkStringlengthBasedOnType($attribute, $param)
    {
        $len = self::CONTENT_LENGTH[$this->type];
        if(isset($len) && $len < strlen($this->$attribute))
        {
            $this->addError($attribute, Yii::t('app', '{attribute} darf maximal {length} Zeichen lang sein',['attribute' => $this->attributeLabels()[$attribute],'length' => $len]));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'pdf_download_id' => Yii::t('app', 'Pdf Download ID'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];

        if($this->type == self::TYPE_HEADER)
        {
            $labels = array_merge($labels, ['content' => Yii::t('app', 'Headerinhalt')]);
        }
        elseif($this->type == self::TYPE_FOOTER)
        {
            $labels = array_merge($labels, ['content' => Yii::t('app', 'Footerinhalt')]);
        }
        else
        {
            $labels = array_merge($labels, ['content' => Yii::t('app', 'Content')]);
        }
        return $labels;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdfDownload()
    {
        return $this->hasOne(PdfDownload::class, ['id' => 'pdf_download_id']);
    }

    /**
     * {@inheritdoc}
     * @return PdfDownloadStringQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PdfDownloadStringQuery(get_called_class());
    }
}
