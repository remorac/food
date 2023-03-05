<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property string $date
 * @property integer $shift_id
 * @property string $datetime_start_order
 * @property string $datetime_end_order
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Order[] $orders
 * @property User $createdBy
 * @property User $updatedBy
 * @property Shift $shift
 */
class Schedule extends \yii\db\ActiveRecord
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
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'shift_id', 'datetime_start_order', 'datetime_end_order'], 'required'],
            [['date', 'datetime_start_order', 'datetime_end_order'], 'safe'],
            [['shift_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['shift_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Tanggal',
            'shift_id' => 'Shift',
            'datetime_start_order' => 'Waktu Awal Pemesanan',
            'datetime_end_order' => 'Waktu Akhir Pemesanan',
            'description' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleMenus()
    {
        return $this->hasMany(ScheduleMenu::className(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['schedule_id' => 'id']);
    }
    public function getOrdersAccepted()
    {
        return $this->hasMany(Order::className(), ['schedule_id' => 'id'])->where(['review_status' => Order::REVIEW_STATUS_ACCEPTED]);
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
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id' => 'shift_id']);
    }

    public function getShortText()
    {
        return date('D, d M Y', strtotime($this->date)).' - '.$this->shift->name;
    }

    public function getTitleCssClass()
    {
        if ($this->shift_id == 1) return 'text-success';
        if ($this->shift_id == 2) return 'text-danger';
        if ($this->shift_id == 3) return 'text-warning';
        return '';
    }

    public function getMenuBadge()
    {
        $menuCssClass = 'danger';
        $menuLabel    = 'BELUM ADA MENU';
        $count        = count($this->scheduleMenus);
        if ($count) {
            $menuCssClass = 'success';
            $menuLabel    = $count.' JENIS MENU';
        } 
        return '<span class="mt-2 label label-inline label-'.$menuCssClass.'">'.$menuLabel.'</span>';
    }

    public function getEligibleUsersCount()
    {
        $return = 0;
        if (date('w', strtotime($this->date)) != 0 && date('w', strtotime($this->date)) != 6) $return+= User::find()->where(['group_id' => null])->count();
        $return+= User::find()->joinWith(['group.groupShifts'])->where([
            'and',
            ['is not', 'user.group_id', null],
            ['group_shift.date' => $this->date],
        ])->count();
        
        return $return;
    }
}
