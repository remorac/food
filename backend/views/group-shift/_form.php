<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\entity\Group;
use common\models\entity\Shift;

/* @var $this yii\web\View */
/* @var $model common\models\entity\GroupShift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-shift-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::class, [
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'readonly' => true,
        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
    ]); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Group::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ]); ?>

    <?= $form->field($model, 'shift_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Shift::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ]); ?>

    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
