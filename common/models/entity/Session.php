<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property string $id
 * @property integer $expire
 * @property resource $data
 * @property integer $user_id
 * @property string $ip_address
 * @property string $remote_addr
 * @property string $http_x_forwarded_for
 * @property string $http_user_agent
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            \yii\behaviors\BlameableBehavior::class,
            \bedezign\yii2\audit\AuditTrailBehavior::class,
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['expire', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 40],
            [['ip_address', 'remote_addr', 'http_x_forwarded_for', 'http_user_agent'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expire' => 'Expire',
            'data' => 'Data',
            'user_id' => 'User',
            'ip_address' => 'Ip Address',
            'remote_addr' => 'Remote Addr',
            'http_x_forwarded_for' => 'Http X Forwarded For',
            'http_user_agent' => 'Http User Agent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
