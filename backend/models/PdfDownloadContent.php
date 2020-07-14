<?php

namespace backend\models;

use common\models\BaseData;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "pdf_download_content".
 *
 * @property int $id
 * @property int $pdf_download_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PdfDownload $pdfDownload
 */
class PdfDownloadContent extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const CONTENT_COVER_PAGE     = '_cover_page';
    const CONTENT_BASE_DATA      = '_base_data';
    const CONTENT_PREFACE        = '_preface';
    const CONTENT_PROVIDER_DATA  = '_provider_data';
    const CONTENT_FUNCTIONS      = '_functions';
    const CONTENT_FINAL_PAGE     = '_final_page';
    const CONTENT_FUNCTIONS_TEXT = '_functions_text';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pdf_download_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_download_id', 'content'], 'required'],
            [['pdf_download_id'], 'integer'],
            [['content'], 'string'],
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
            'id' => Yii::t('app', 'ID'),
            'pdf_download_id' => Yii::t('app', 'Pdf Download ID'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
     * Returns a list of available content types for PDF generation
     *
     * @param BaseData $baseData
     *
     * @return array
     */
    public static function getContentList(BaseData $baseData)
    {
        $showCoverPage = false;
        $showPreface   = false;
        $showFinalPage = false;
        if (0 < count($baseData->attachment))
        {
            foreach ($baseData->attachment AS $attachment)
            {
                if ($attachment->category == Attachment::CATEGORY_COVER_PAGE)
                {
                    $showCoverPage = true;
                }
                elseif ($attachment->category == Attachment::CATEGORY_PREFACE)
                {
                    $showPreface = true;
                }
                elseif ($attachment->category == Attachment::CATEGORY_FINAL_PAGE)
                {
                    $showFinalPage = true;
                }
            }
        }
        $contentList = [];
        if ($showCoverPage)
        {
            $contentList[self::CONTENT_COVER_PAGE] = Yii::t('app', 'Deckblatt');
        }
        $contentList[self::CONTENT_BASE_DATA] = Yii::t('app', 'Projektdaten');
        if ($showPreface)
        {
            $contentList[self::CONTENT_PREFACE] = Yii::t('app', 'Vorbemerkung');
        }
        $contentList[self::CONTENT_PROVIDER_DATA] = Yii::t('app', 'Anbieterdaten');
        $contentList[self::CONTENT_FUNCTIONS]     = Yii::t('app', 'Funktionen');
        $contentList[self::CONTENT_FUNCTIONS_TEXT] = Yii::t('app', 'Funktionsbeschreibung');
        if ($showFinalPage)
        {
            $contentList[self::CONTENT_FINAL_PAGE] = Yii::t('app', 'Schlussseite');
        }

        return $contentList;
    }
}
