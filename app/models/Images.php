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

    /**
     * @var mixed image the attribute for rendering the file input
     * widget for upload on the form
     */

    public $image;

    public function rules()
    {
        return [
            [['name', 'image', 'filename', 'file'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, gif, png'],
        ];
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        \Yii::$app->params['uploadPath'] = \Yii::$app->basePath . '/../uploads/';
        \Yii::$app->params['uploadUrl'] = \Yii::$app->urlManager->baseUrl . '/uploads/';
        return isset($this->file) ? \Yii::$app->params['uploadPath'] . $this->file : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        \Yii::$app->params['uploadUrl'] = \Yii::$app->urlManager->baseUrl . '/uploads/';
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
        \Yii::$app->params['uploadPath'] = \Yii::$app->basePath . '/../uploads/';
        \Yii::$app->params['uploadUrl'] = \Yii::$app->urlManager->baseUrl . '/uploads/';
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
}
