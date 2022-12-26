<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'guest/main';
?>

<div class="login-forgot">
    <div class="mb-20">
        <h3>Reset Password</h3>
        <div class="text-muted font-weight-bold">Please set your new password</div>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <div class="form-group mb-5">
        <?= Html::activePasswordInput($model, 'password', [
            'autofocus' => true,
            'class' => 'form-control form-control-solid h-auto py-4 px-8',
            'placeholder' => 'new password',
            'autocomplete' => 'off',
        ]) ?>
        <?= Html::error($model, 'password', ['class' => 'text-danger text-left small help-block']) ?>
        </div>

        <div class="form-group d-flex flex-wrap flex-center mt-10">
            <a href="<?= Url::to(['/']) ?>" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</a>
            <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Save</button>
        </div>

    <?php ActiveForm::end(); ?>

</div>
