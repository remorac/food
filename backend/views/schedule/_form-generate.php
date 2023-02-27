<?php

use common\models\entity\Schedule;
use common\models\entity\Shift;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="form-group custom-control custom-radio" style="padding-left:0">
        <?= Html::radioList('generator_shift_id', null, ArrayHelper::map(Shift::find()->asArray()->all(), 'id', 'name')) ?>
    </div>

    <div class="form-group">
        <label>
            Jam Makan
            <div class="text-muted font-size-sm font-weight-normal">format: hh:mm</div>
        </label>
        <?= Html::textInput('generator_time', null, [
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <label>
            Tanggal Mulai
            <div class="text-muted font-size-sm font-weight-normal">Generate jadwal mulai tanggal</div>
        </label>
        <?= DatePicker::widget([
            'name' => 'generator_date_start',
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'readonly' => true,
            'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
        ]) ?>
    </div>

    <div class="form-group">
        <label>
            Tanggal Selesai
            <div class="text-muted font-size-sm font-weight-normal">Generate jadwal hingga tanggal</div>
        </label>
        <?= DatePicker::widget([
            'name' => 'generator_date_end',
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'readonly' => true,
            'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
        ]) ?>
    </div>

    <div class="form-group">
        <label>
            Mulai Pemesanan
            <div class="text-muted font-size-sm font-weight-normal">Makanan dapat dipesan mulai berapa jam sebelum waktu makan?</div>
        </label>
        <?= Html::textInput('generator_order_start', null, [
            'type' => 'number',
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <label>
            Selesai Pemesanan
            <div class="text-muted font-size-sm font-weight-normal">Pemesanan ditutup mulai berapa jam sebelum waktu makan?</div>
        </label>
        <?= Html::textInput('generator_order_end', null, [
            'type' => 'number',
            'class' => 'form-control',
        ]) ?>
    </div>
    
    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .custom-radio label {
        display: block;
        font-weight: bold !important;
    }
    .custom-radio input {
        margin-right: 4px;
    }
</style>