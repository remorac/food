<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $user_id
 * @property integer $menu_id
 * @property integer $location_id
 * @property integer $review_status
 * @property integer $reviewed_at
 * @property integer $reviewed_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $user
 * @property Location $location
 * @property User $reviewedBy
 * @property User $createdBy
 * @property User $updatedBy
 * @property Schedule $schedule
 * @property Menu $menu
 */
class Order extends \yii\db\ActiveRecord
{
    const REVIEW_STATUS_WAITING  = 0;
    const REVIEW_STATUS_ACCEPTED = 1;
    const REVIEW_STATUS_REJECTED = 2;

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
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'user_id', 'menu_id', 'location_id'], 'required'],
            [['schedule_id', 'user_id', 'menu_id', 'location_id', 'review_status', 'reviewed_at', 'reviewed_by', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['reviewed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reviewed_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schedule::className(), 'targetAttribute' => ['schedule_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schedule_id' => 'Jadwal',
            'user_id' => 'User',
            'menu_id' => 'Menu',
            'location_id' => 'Location',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleMenu()
    {
        return ScheduleMenu::findOne(['schedule_id' => $this->schedule_id, 'menu_id' => $this->menu_id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    public static function reviewStatuses($index = null, $html = false) {
        $array = [
            self::REVIEW_STATUS_WAITING => 'Ditinjau',
            self::REVIEW_STATUS_ACCEPTED => 'Disetujui',
            self::REVIEW_STATUS_REJECTED => 'Ditolak',
        ];
        if ($html) {
            $array = [
                self::REVIEW_STATUS_WAITING => '<span class="font-weight-bold label label-inline label-light">Ditinjau</span>',
                self::REVIEW_STATUS_ACCEPTED => '<span class="font-weight-bold label label-inline label-light-success">Disetujui</span>',
                self::REVIEW_STATUS_REJECTED => '<span class="font-weight-bold label label-inline label-light-danger">Ditolak</span>',
            ];
        }
        if ($index === null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getReviewStatusHtml()
    {
        return self::reviewStatuses($this->review_status, true);
    }

    public function getEligibilityLabel()
    {
        if ($this->user->group_id != null) {
            $groupShift = GroupShift::find()->where([
                'date' => $this->schedule->date,
                'shift_id' => 1,
                'group_id' => $this->user->group_id,
            ])->one();
            if ($groupShift) {
                return '<span class="label label-inline label-light-success">Shift '.$this->user->group->name.' - sesuai jadwal</span>';
            } else {
                $groupShift = GroupShift::find()->where([
                    'date' => $this->schedule->date,
                    'shift_id' => 1,
                ])->one();
                return '<span class="label label-inline label-light-danger">Shift '.$this->user->group->name.' ke '.$groupShift->group->name.' - ganti jadwal</span>';
            }
        } else {
            if ($this->schedule->shift_id == 1) {
                return '<span class="label label-inline label-light-success">Non Shift - sesuai jadwal</span>';
            } else {
                return '<span class="label label-inline label-light-danger">Non Shift - lembur</span>';
            }
        }

        return '';
    }
}
