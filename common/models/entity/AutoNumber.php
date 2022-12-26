<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "auto_number".
 *
 * @property string $group
 * @property integer $number
 * @property integer $optimistic_lock
 * @property integer $update_time
 */
class AutoNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
            \bedezign\yii2\audit\AuditTrailBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group'], 'required'],
            [['number', 'optimistic_lock', 'update_time'], 'integer'],
            [['group'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Group',
            'number' => 'Number',
            'optimistic_lock' => 'Optimistic Lock',
            'update_time' => 'Update Time',
        ];
    }
}
