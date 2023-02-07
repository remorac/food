<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $file_image
 * @property integer $quota
 * @property integer $is_active_sunday
 * @property integer $is_active_monday
 * @property integer $is_active_tuesday
 * @property integer $is_active_wednesday
 * @property integer $is_active_thursday
 * @property integer $is_active_friday
 * @property integer $is_active_saturday
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Order[] $orders
 */
class Menu extends \yii\db\ActiveRecord
{
    const TYPE_PRIMARY = 1;
    const TYPE_SECONDARY = 2;

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
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'quota', 'is_active_sunday', 'is_active_monday', 'is_active_tuesday', 'is_active_wednesday', 'is_active_thursday', 'is_active_friday', 'is_active_saturday', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description', 'file_image'], 'string'],
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
            'name' => 'Nama',
            'type' => 'Jenis',
            'description' => 'Keterangan',
            'quota' => 'Kuota',
            'file_image' => 'Foto',
            'quota' => 'Quota',
            'is_active_sunday' => 'Minggu',
            'is_active_monday' => 'Senin',
            'is_active_tuesday' => 'Selasa',
            'is_active_wednesday' => 'Rabu',
            'is_active_thursday' => 'Kamis',
            'is_active_friday' => 'Jumat',
            'is_active_saturday' => 'Sabtu',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['menu_id' => 'id']);
    }

    public static function types($index = null, $html = false) {
        $array = [
            self::TYPE_PRIMARY => 'Menu Utama',
            self::TYPE_SECONDARY => 'Menu Pengganti',
        ];
        if ($html) {
            $array = [
                self::TYPE_PRIMARY => '<span class="font-weight-bold label label-inline label-light-primary">Menu Utama</span>',
                self::TYPE_SECONDARY => '<span class="font-weight-bold label label-inline label-light-secondary text-dark-50">Menu Pengganti</span>',
            ];
        }
        if ($index === null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getTypeText()
    {
        return self::types($this->type ?? 0);
    }

    public function getTypeHtml()
    {
        return self::types($this->type ?? 0, true);
    }
}
