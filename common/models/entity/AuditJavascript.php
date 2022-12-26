<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "audit_javascript".
 *
 * @property integer $id
 * @property integer $entry_id
 * @property string $created
 * @property string $type
 * @property string $message
 * @property string $origin
 * @property resource $data
 *
 * @property AuditEntry $entry
 */
class AuditJavascript extends \yii\db\ActiveRecord
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
        return 'audit_javascript';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry_id', 'created', 'type', 'message'], 'required'],
            [['entry_id'], 'integer'],
            [['created'], 'safe'],
            [['message', 'data'], 'string'],
            [['type'], 'string', 'max' => 20],
            [['origin'], 'string', 'max' => 512],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuditEntry::className(), 'targetAttribute' => ['entry_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_id' => 'Entry',
            'created' => 'Created',
            'type' => 'Type',
            'message' => 'Message',
            'origin' => 'Origin',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(AuditEntry::className(), ['id' => 'entry_id']);
    }
}
