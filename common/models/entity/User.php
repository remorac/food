<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $phone
 * @property string $email
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $one_time_password
 * @property integer $otp_expired_at
 * @property integer $must_change_password
 * @property integer $confirmed_at
 * @property integer $status
 * @property string $name
 * @property integer $unit_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthAssignment[] $authAssignments0
 * @property AuthItem[] $authItems
 * @property AuthItem[] $authItems0
 * @property Menu[] $menus
 * @property Menu[] $menus0
 * @property Order[] $orders
 * @property Order[] $orders0
 * @property Order[] $orders1
 * @property Order[] $orders2
 * @property Schedule[] $schedules
 * @property Schedule[] $schedules0
 * @property ScheduleMenu[] $scheduleMenus
 * @property ScheduleMenu[] $scheduleMenus0
 * @property Session[] $sessions
 * @property Unit[] $units
 * @property Unit[] $units0
 * @property Unit $unit
 */
class User extends \common\models\User
{
    public $password;
    public $role;

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
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', /* 'username', 'auth_key', 'password_hash' */], 'required'],
            [['otp_expired_at', 'must_change_password', 'confirmed_at', 'status', 'unit_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['phone', 'email', 'username', 'password_hash', 'password_reset_token', 'verification_token', 'one_time_password', 'name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],

            [['password'], 'required', 'on' => 'create'],
            [['password'], 'string', 'min' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'email' => 'Email',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'one_time_password' => 'One Time Password',
            'otp_expired_at' => 'Otp Expired At',
            'must_change_password' => 'Must Change Password',
            'confirmed_at' => 'Confirmed At',
            'status' => 'Status',
            'name' => 'Nama',
            'unit_id' => 'Unit Kerja',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments0()
    {
        return $this->hasMany(AuthAssignment::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems0()
    {
        return $this->hasMany(AuthItem::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus0()
    {
        return $this->hasMany(Menu::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::className(), ['reviewed_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders1()
    {
        return $this->hasMany(Order::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders2()
    {
        return $this->hasMany(Order::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules0()
    {
        return $this->hasMany(Schedule::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Session::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits0()
    {
        return $this->hasMany(Unit::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public static function statuses($index = null, $html = false) {
        $array = [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Inaktif',
        ];
        if ($html) {
            $array = [
                self::STATUS_ACTIVE => '<span class="font-weight-bold label label-inline label-light-success">Aktif</span>',
                self::STATUS_INACTIVE => '<span class="font-weight-bold label label-inline label-light-danger">Inaktif</span>',
            ];
        }
        if ($index === null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getStatusText()
    {
        return self::statuses($this->status ?? 0);
    }

    public function getStatusHtml()
    {
        return self::statuses($this->status ?? 0, true);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateEmailVerificationToken();
            $this->username = Yii::$app->security->generateRandomString();
        }
        if ($this->password) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }
        if ($this->phone) {
            $this->phone = parsePhone($this->phone);
        }
        
        return parent::beforeSave($insert);
    }
}
