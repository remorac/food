<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
use common\models\entity\Unit;
use common\models\entity\Supplier;
use common\models\entity\User;

/* @var $this yii\web\View */
/* @var $model common\models\entity\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= '' // $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'password')->passwordInput()->hint($model->isNewRecord ? '' : 'kosongkan jika tidak ingin mengganti password.') ?>
    <?= $form->field($model, 'password')->textInput()->hint($model->isNewRecord ? '' : 'kosongkan jika tidak ingin mengganti password.') ?>

    <?= $form->field($model, 'status')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => User::statuses(),
        // 'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ]); ?>

    <?= '' /* $form->field($model, 'unit_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Unit::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ]); */ ?>

    <?= '' /* $form->field($model, 'supplier_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Supplier::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ]); */ ?>

    
    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
