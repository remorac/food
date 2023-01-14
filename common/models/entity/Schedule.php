<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property string $name
 * @property string $datetime
 * @property string $datetime_start_order
 * @property string $datetime_end_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Order[] $orders
 * @property User $createdBy
 * @property User $updatedBy
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
            [['name', 'datetime', 'datetime_start_order', 'datetime_end_order'], 'required'],
            [['datetime', 'datetime_start_order', 'datetime_end_order'], 'safe'],
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
            'name' => 'Keterangan',
            'datetime' => 'Waktu Makan',
            'datetime_start_order' => 'Waktu Mulai Pemesanan',
            'datetime_end_order' => 'Waktu Akhir Pemesanan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
}
