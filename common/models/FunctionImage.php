<?php

namespace common\models;

use common\models\queries\FunctionImageQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "function_image".
 *
 * @property int $id
 * @property int $function_id
 * @property string $image
 * @property string $extension
 * @property string $original_name
 * @property string $hash
 * @property int $sort
 *
 * @property Function $function
 */
class FunctionImage extends \yii\db\ActiveRecord
{
    const PREFIX_ORIGINAL       = 'o_';
    const PREFIX_THUMBNAIL      = 't_';
    const FUNCTION_IMAGE_FOLDER = 'component_images';
    const THUMBNAIL_BOX_WIDTH   = 100;
    const THUMBNAIL_BOX_HEIGHT  = 100;
    const THUMBNAIL_QUALITY     = 70;
    const THUMBNAIL_EXTENSION   = 'png';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => 'sjaakp\sortable\Sortable',
                'orderAttribute' => [
                    'function_id' => 'sort'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'function_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['function_id', 'sort', 'image', 'extension', 'original_name'], 'required'],
            [['function_id', 'sort'], 'integer'],
            [['image', 'original_name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 100],
            [['hash'], 'string', 'max' => 64],
            [['hash'], 'unique', 'targetAttribute' => ['function_id', 'hash'], 'message' => Yii::t('app','Eines der hochgeladenen Bilder existiert in dieser Funktion bereits.')],
            [['function_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['function_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'function_id'   => Yii::t('app', 'Function ID'),
            'image'         => Yii::t('app', 'Bild'),
            'original_name' => Yii::t('app', 'ursprünglicher Name'),
            'hash'          => Yii::t('app', 'Hash'),
            'extension'     => Yii::t('app', 'Dateityp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunction()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }

    /**
     * returns the image's absolute or relative filename + path to the original or thumbnail depending on the prefix
     *
     * @param      $prefix
     * @param bool $absolute
     *
     * @return string
     */
    public function getFullFileNameAndPath($prefix, $absolute = false)
    {
        if($prefix == self::PREFIX_THUMBNAIL)
        {
            $fileExtension = self::THUMBNAIL_EXTENSION;
        }
        else
        {
            $fileExtension = $this->extension;
        }
        return ($absolute ? (Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR) : '') . Yii::$app->params['uploadDirectory'] . DIRECTORY_SEPARATOR . FunctionImage::FUNCTION_IMAGE_FOLDER . DIRECTORY_SEPARATOR . $prefix . $this->image . '.' . $fileExtension;
    }


    /**
     * @return FunctionImageQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new FunctionImageQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if(parent::delete())
        {
            //Remove image files associated with model
            unlink($this->getFullFileNameAndPath(FunctionImage::PREFIX_ORIGINAL, true));
            unlink($this->getFullFileNameAndPath(FunctionImage::PREFIX_THUMBNAIL, true));
            return true;
        }
        return false;
    }
}
