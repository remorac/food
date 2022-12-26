<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "reservation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $schedule_menu_id
 * @property integer $review_status
 * @property integer $reviewed_at
 * @property integer $reviewed_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $user
 * @property ScheduleMenu $scheduleMenu
 * @property User $reviewedBy
 * @property User $createdBy
 * @property User $updatedBy
 */
class Reservation extends \yii\db\ActiveRecord
{
    public $schedule_id;

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
        return 'reservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'schedule_menu_id'], 'required'],
            [['user_id', 'schedule_menu_id', 'review_status', 'reviewed_at', 'reviewed_by', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['schedule_menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleMenu::className(), 'targetAttribute' => ['schedule_menu_id' => 'id']],
            [['reviewed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reviewed_by' => 'id']],
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
            'user_id' => 'User',
            'schedule_menu_id' => 'Schedule Menu',
            'review_status' => 'Review Status',
            'reviewed_at' => 'Reviewed At',
            'reviewed_by' => 'Reviewed By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleMenu()
    {
        return $this->hasOne(ScheduleMenu::className(), ['id' => 'schedule_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'reviewed_by']);
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

    public function afterFind()
    {
        $this->schedule_id = $this->scheduleMenu->schedule_id;
    }
}
