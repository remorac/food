<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'guest/main';
?>

<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

<!--begin::Login forgot password form-->
<div class="login-forgot">
    <div class="card card-custom">
        <div class="card-body">
            <div class="mb-20">
                <h3>Lupa Password ?</h3>
                <div class="text-muted font-weight-bold">Masukkan email terdaftar. Link untuk reset password akan dikirimkan ke email tersebut.</div>
            </div>

            <div class="form-group mb-5">
            <?= Html::activeTextInput($model, 'email', [
                'autofocus' => true,
                'class' => 'form-control form-control-solid h-auto py-4 px-8',
                'placeholder' => 'email',
                'autocomplete' => 'off',
            ]) ?>
            <?= Html::error($model, 'email', ['class' => 'text-danger text-left small help-block']) ?>
            </div>

            <div class="form-group d-flex flex-wrap flex-end mt-10">
                <a href="<?= Url::to(['/']) ?>" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Batal</a>
                <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Kirim</button>
            </div>
        </div>
    </div>

</div>
<!--end::Login forgot password form-->

<?php ActiveForm::end(); ?>