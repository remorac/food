<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "audit_mail".
 *
 * @property integer $id
 * @property integer $entry_id
 * @property string $created
 * @property integer $successful
 * @property string $from
 * @property string $to
 * @property string $reply
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property resource $text
 * @property resource $html
 * @property resource $data
 *
 * @property AuditEntry $entry
 */
class AuditMail extends \yii\db\ActiveRecord
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
        return 'audit_mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry_id', 'created', 'successful'], 'required'],
            [['entry_id', 'successful'], 'integer'],
            [['created'], 'safe'],
            [['text', 'html', 'data'], 'string'],
            [['from', 'to', 'reply', 'cc', 'bcc', 'subject'], 'string', 'max' => 255],
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
            'successful' => 'Successful',
            'from' => 'From',
            'to' => 'To',
            'reply' => 'Reply',
            'cc' => 'Cc',
            'bcc' => 'Bcc',
            'subject' => 'Subject',
            'text' => 'Text',
            'html' => 'Html',
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
