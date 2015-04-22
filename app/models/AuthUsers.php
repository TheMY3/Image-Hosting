<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_users".
 *
 * @property integer $id_auth
 * @property integer $id_user
 * @property string $source
 * @property string $source_id
 *
 * @property Users $idUser
 */
class AuthUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'source', 'source_id'], 'required'],
            [['id_user'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_auth' => Yii::t('app', 'Id Auth'),
            'id_user' => Yii::t('app', 'Id User'),
            'source' => Yii::t('app', 'Source'),
            'source_id' => Yii::t('app', 'Source ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }
}
