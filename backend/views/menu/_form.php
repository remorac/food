<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <label for="">Tersedia pada</label>
        <br><?= Html::checkbox('Menu[is_active_sunday]', $model->is_active_sunday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_sunday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_monday]', $model->is_active_monday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_monday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_tuesday]', $model->is_active_tuesday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_tuesday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_wednesday]', $model->is_active_wednesday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_wednesday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_thursday]', $model->is_active_thursday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_thursday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_friday]', $model->is_active_friday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_friday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
        <br><?= Html::checkbox('Menu[is_active_saturday]', $model->is_active_saturday, ['label' => '&nbsp;'.$model->getAttributeLabel('is_active_saturday'), 'labelOptions' => ['class' => 'checkbox-label']]) ?>
    </div>

    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
