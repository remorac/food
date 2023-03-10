<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "audit_entry".
 *
 * @property integer $id
 * @property string $created
 * @property integer $user_id
 * @property double $duration
 * @property string $ip
 * @property string $request_method
 * @property integer $ajax
 * @property string $route
 * @property integer $memory_max
 *
 * @property AuditData[] $auditDatas
 * @property AuditError[] $auditErrors
 * @property AuditJavascript[] $auditJavascripts
 * @property AuditMail[] $auditMails
 * @property AuditTrail[] $auditTrails
 */
class AuditEntry extends \yii\db\ActiveRecord
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
        return 'audit_entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created'], 'required'],
            [['created'], 'safe'],
            [['user_id', 'ajax', 'memory_max'], 'integer'],
            [['duration'], 'number'],
            [['ip'], 'string', 'max' => 45],
            [['request_method'], 'string', 'max' => 16],
            [['route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'user_id' => 'User',
            'duration' => 'Duration',
            'ip' => 'Ip',
            'request_method' => 'Request Method',
            'ajax' => 'Ajax',
            'route' => 'Route',
            'memory_max' => 'Memory Max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditDatas()
    {
        return $this->hasMany(AuditData::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditErrors()
    {
        return $this->hasMany(AuditError::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditJavascripts()
    {
        return $this->hasMany(AuditJavascript::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditMails()
    {
        return $this->hasMany(AuditMail::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditTrails()
    {
        return $this->hasMany(AuditTrail::className(), ['entry_id' => 'id']);
    }
}
