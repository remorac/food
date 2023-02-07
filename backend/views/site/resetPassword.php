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
        <?= $form->field($model, 'password', [
            'inputTemplate' => '
                <div class="input-group">
                    {input}
                    <div class="input-group-append">
                        <span class="input-group-text" style="border: none"><i class="far fa-eye" id="togglePassword" style="cursor: pointer"></i></span>
                    </div>
                </div>'
        ])->passwordInput([
            'class' => 'form-control h-auto form-control-solid py-4 px-8',
            'placeholder' => 'password',
        ])->label(false) ?>
        </div>

        <div class="form-group d-flex flex-wrap flex-center mt-10">
            <a href="<?= Url::to(['/']) ?>" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</a>
            <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Save</button>
        </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<<JAVASCRIPT

console.log('js is loaded by yii.');

const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#loginform-password');

/* togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
}); */

togglePassword.addEventListener('mousedown', function (e) {
    password.setAttribute('type', 'text');
    this.classList.add('fa-eye-slash');
});

togglePassword.addEventListener('mouseup', function (e) {
    password.setAttribute('type', 'password');
    this.classList.remove('fa-eye-slash');
});
JAVASCRIPT;

// $this->registerJs($js, \yii\web\View::POS_READY);
?>


<script type="text/javascript">

console.log('js is loaded by html.');

const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#loginform-password');

/* togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
}); */

togglePassword.addEventListener('mousedown', function (e) {
    password.setAttribute('type', 'text');
    this.classList.add('fa-eye-slash');
});

togglePassword.addEventListener('mouseup', function (e) {
    password.setAttribute('type', 'password');
    this.classList.remove('fa-eye-slash');
});
</script>