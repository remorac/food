<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Salesman */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Ganti Password';
?>


<div class="row">
    <div class="col-6">
        <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="card card-custom">
                <div class="card-body">
                    <?= $form->field($model,'password_old')->passwordInput() ?>
                    <?= $form->field($model,'password_new')->passwordInput() ?>
                    <?= $form->field($model,'password_new_confirmation')->passwordInput() ?>
                </div>
                <div class="card-footer text-right bg-light">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Change Password', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
