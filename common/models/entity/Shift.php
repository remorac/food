<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property GroupShift[] $groupShifts
 * @property MenuAvailability[] $menuAvailabilities
 * @property Schedule[] $schedules
 * @property User $createdBy
 * @property User $updatedBy
 */
class Shift extends \yii\db\ActiveRecord
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
        return 'shift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_time', 'end_time'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupShifts()
    {
        return $this->hasMany(GroupShift::className(), ['shift_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuAvailabilities()
    {
        return $this->hasMany(MenuAvailability::className(), ['shift_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['shift_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
