<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Images
 * @package common\models
 * @property int $id unique image identifier
 * @property string $name image name
 * @property array $image generated filename on server
 * @property string $filename source filename from client
 */
class Images extends ActiveRecord
{

    public static function tableName()
    {
        return 'images';
    }

    public $size;
    public $size_height;
    public $size_width;
    public $rotate;
    public $rotate_value;
    public $negattive;
    public $grayscale;
    public $watermark;
    public $flip;
    public $flip_value;

    /**
     * @var mixed image the attribute for rendering the file input
     * widget for upload on the form
     */

    public $image;

    public function rules()
    {
        return [
            [['image', 'filename', 'file', 'created', 'id_user', 'status', 'size', 'size_height', 'size_width', 'rotate', 'rotate_value', 'negattive', 'grayscale', 'watermark', 'flip', 'flip_value'], 'safe', 'on' => 'default'],
            [['name'], 'safe', 'on' => 'update'],
            ['status', 'default', 'value' => 1],
            [['likes', 'views'], 'integer'],
            [['name', 'description'], 'string', 'max' => 30],
            [['image'], 'file', 'extensions' => 'jpg, gif, png'],
            [['size_height', 'size_width'], 'required', 'when' => function ($model) {
                return $model->size == true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#images-size').is(':checked');
            }"],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'watermark' => 'Показывать копирайт',
            'status' => 'Отображать в Галерее',
            'size' => 'Изменить размер',
            'size_height' => 'Высота',
            'size_width' => 'Ширина',
            'rotate' => 'Повернуть изображение',
            'rotate_value' => 'Повернуть на',
            'flip' => 'Отразить изображение',
            'flip_value' => 'Отразить',
            'negattive' => 'Сделать изображение негативным (обратить цвета)',
            'grayscale' => 'Сделать изображение черно-белым (в оттенках серого)',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!\Yii::$app->user->isGuest) {
                $this->id_user = \Yii::$app->user->id;
            }
            $this->created = time();
            return true;
        } else {
            return false;
        }
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        return isset($this->file) ? \Yii::$app->params['uploadPath'] . $this->file : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        // return a default image placeholder if your source image is not found
        $image = isset($this->file) ? $this->file : 'default_user.jpg';
        return \Yii::$app->params['uploadUrl'] . $image;
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage()
    {
    // get the uploaded file instance. for multiple file uploads
    // the following data will return an array (you may need to use
    // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        $this->file = \Yii::$app->security->generateRandomString() . ".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage()
    {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->image = null;
        $this->filename = null;

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }
}
