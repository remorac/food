<?php

use DeviceDetector\DeviceDetector;

/**
 * Debug function
 * d($var);
 */
function d($var)
{
    echo '<pre>';
    yii\helpers\VarDumper::dump($var, 10, true);
    echo '</pre>';
}

/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var)
{
    d($var);
    die();
} 

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function years() 
{
    $years = [];
    for ($i = date('Y'); $i >= 2018 ; $i--) { 
        $years[$i] = $i;
    }
    return $years;
}

function months() {
    $months = [];
    for ($i = 1; $i <= 12 ; $i++) { 
        $months[$i] = date('F', mktime(0, 0, 0, $i, 10));
    }
    return $months;
}

function monthName($month) 
{
    return date('F', mktime(0, 0, 0, $month, 10));
}

function monthsRoman($month)
{
    $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return $romans[date($month)-1];
}

function dateDiff($dateString1, $dateString2, $days = 1)
{
    $datetime1 = new DateTime($dateString1);
    $datetime2 = new DateTime($dateString2);
    $difference = $datetime1->diff($datetime2);
    return $days ? $difference->days : $difference;
}

function dateDuration($dateString1, $dateString2)
{
    return dateDiff($dateString1, $dateString2) + 1;
}

function uploadFile($model, $field, $uploadedFile)
{
    $filename  = $model->id .'.'. $uploadedFile->extension;
    $directory = Yii::getAlias('@uploads/'.$model->tableName().'/'.$field);

    if (!file_exists($directory)) mkdir($directory, 0777, true);
    if ($uploadedFile->saveAs($directory.'/'.$filename)) {
        $model->$field = $uploadedFile->name;
        if ($model->save()) return true;
    }
    return false;
}

function downloadFile($model, $field, $filename = null)
{
    if ($model->$field) {
        // $array     = explode('.', $model->$field);
        // $extension = end($array);
        $extension = strtolower(pathinfo($model->$field, PATHINFO_EXTENSION));
        $filepath  = Yii::getAlias('@uploads/'.$model->tableName().'/'.$field.'/'.$model->id.'.'.$extension);
        $filename  = $filename ? $filename.'.'. $extension : $model->$field;
        if (file_exists($filepath)) {
            return Yii::$app->response->sendFile($filepath, $filename, ['inline' => true]);
        }
    }
    // return Yii::$app->response->redirect(Yii::$app->request->referrer);
}

function parsePhone($phone)
{
    if ($phone) {
        if (substr($phone,0,1) == '+')  $phone = $phone;
        if (substr($phone,0,2) == '62') $phone = '+'.$phone;
        if (substr($phone,0,1) >= '1')  $phone = '+62'.$phone;
        if (substr($phone,0,1) == '0')  $phone = '+62'.ltrim($phone, '0');
    }
    return $phone;
}

function areaFields()
{
    return [
        'province_id',
        'district_id',
        'subdistrict_id',
        'village_id',
    ];
}

function denominate($value) 
{
    $value = abs($value);
    $words = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $return = "";
    if ($value < 12) {
        $return = " ". $words[$value];
    } else if ($value < 20) {
        $return = denominate($value - 10). " belas";
    } else if ($value < 100) {
        $return = denominate($value/10)." puluh". denominate($value % 10);
    } else if ($value < 200) {
        $return = " seratus" . denominate($value - 100);
    } else if ($value < 1000) {
        $return = denominate($value/100) . " ratus" . denominate($value % 100);
    } else if ($value < 2000) {
        $return = " seribu" . denominate($value - 1000);
    } else if ($value < 1000000) {
        $return = denominate($value/1000) . " ribu" . denominate($value % 1000);
    } else if ($value < 1000000000) {
        $return = denominate($value/1000000) . " juta" . denominate($value % 1000000);
    } else if ($value < 1000000000000) {
        $return = denominate($value/1000000000) . " milyar" . denominate(fmod($value,1000000000));
    } else if ($value < 1000000000000000) {
        $return = denominate($value/1000000000000) . " trilyun" . denominate(fmod($value,1000000000000));
    }
    return $return;
}

function terbilang($value) 
{
    return $value < 0 ? "minus ". trim(denominate($value)) : trim(denominate($value));	
}

function parseUserAgent($http_user_agent, $html = false)
{
    try {
        $return = [];

        $dd = new DeviceDetector($http_user_agent);
        $dd->parse();

        if ($dd->isBot()) {
            $botInfo = $dd->getBot();
            $return[]  = $botInfo;
        } else {
            $device     = $dd->getDeviceName();
            $brand      = $dd->getBrandName();
            $model      = $dd->getModel();
            $osInfo     = $dd->getOs();
            $clientInfo = $dd->getClient();
            
            //device
            if ($brand) $return[] = $brand;
            if ($model) $return[] = $model;
            if ($brand || $model) $return[] = ';';

            //os
            if ($osInfo['name']) $return[] = $osInfo['name'];
            if ($osInfo['version']) $return[] = $osInfo['version'];
            if ($osInfo['platform']) $return[] = $osInfo['platform'];
            if ($osInfo['name'] || $osInfo['version'] || $osInfo['platform']) $return[] = ';';

            // browser, feed reader, media player, ...
            if ($clientInfo['name']) $return[] = $clientInfo['name'];
            if ($clientInfo['version']) $return[] = $clientInfo['version'];

            $label_type = '';
            if ($device == 'desktop') $label_type = '-info';
            if ($device == 'tablet') $label_type = '-primary';
            if ($device == 'phablet') $label_type = '-primary';
            if ($device == 'smartphone') $label_type = '-success';
            if ($device) $return[] = '<span class="label label-inline label-light'.$label_type.'">'.$device.'</span>';
        }
        return str_replace(' ;', ';', implode(' ', $return)).($html ? '<br><small>'.$http_user_agent.'</small>' : '');
    } catch (\Throwable $th) {
        
    }
    return $http_user_agent;
}