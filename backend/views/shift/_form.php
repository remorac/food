<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Shift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shift-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= '' // $form->field($model, 'name')->textInput() ?>

    <h4>Shift <?= $model->name ?></h4>
    <br>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
