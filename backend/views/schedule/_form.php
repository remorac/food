<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    

    <?= $form->field($model, 'datetime_start')->widget(DateTimePicker::class, [
        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
        'readonly' => true,
        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd hh:ii'],
    ]) ?>

    <?= $form->field($model, 'datetime_end')->widget(DateTimePicker::class, [
        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
        'readonly' => true,
        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd hh:ii'],
    ]) ?>

    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
