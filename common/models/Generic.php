<?php

namespace common\models;

use Yii;

/**
 * This is the generic model class.
 */
class Generic extends \yii\db\ActiveRecord
{
    const IS_ACTIVE_TRUE  = 1;
    const IS_ACTIVE_FALSE = 0;    

    public static function isActives($index = null, $html = false) {
        $array = [
            self::IS_ACTIVE_TRUE  => 'Active',
            self::IS_ACTIVE_FALSE => 'Inactive',
        ];
        if ($html) {
            $array = [
                self::IS_ACTIVE_TRUE  => '<span class="font-weight-bold label label-inline label-light-success">Active</span>',
                self::IS_ACTIVE_FALSE => '<span class="font-weight-bold label label-inline label-light-danger">Inactive</span>',
            ];
        }
        if ($index === null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getIsActiveText()
    {
        return self::isActives($this->is_active ?? 0);
    }

    public function getIsActiveHtml()
    {
        return self::isActives($this->is_active ?? 0, true);
    }
}
