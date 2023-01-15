<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'guest/main';
?>

<!--begin::Login Sign in form-->
<div class="login-signin">
    <div class="container h-100">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-32">
                    <div class="card-header">
                        <?= Html::img(Yii::getAlias('@web/img/logo.png'), ['height' => '50px']) ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-12">
                            <h3><?= Yii::$app->name ?></h3>
                            <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
                        </div>
                        <?php $form = ActiveForm::begin(['id' => 'kt_login_signin_form', 'class' => 'form']); ?>

                            <div class="form-group mb-5">
                            <?= $form->field($model, 'email')->textInput([
                                'autofocus' => true,
                                'class' => 'form-control h-auto form-control-solid py-4 px-8',
                                'placeholder' => 'email',
                                'autocomplete' => 'off',
                            ])->label(false) ?>
                            </div>

                            <div class="form-group mb-5">
                            <?= '' /* $form->field($model, 'password')->passwordInput([
                                'class' => 'form-control h-auto form-control-solid py-4 px-8',
                                'placeholder' => 'password',
                            ])->label(false) */ ?>

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

                            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                <div class="checkbox-inline">
                                    <!-- <label class="checkbox m-0 text-muted">
                                    <input type="checkbox" name="LoginForm[rememberMe]" />
                                    <span></span>Remember me</label> -->
                                    <?= Html::activeCheckbox($model, 'rememberMe', ['labelOptions' => ['class' => 'm-0 text-muted']]) ?>
                                </div>
                                <div></div>
                                <a href="<?= Url::to(['/site/request-password-reset']) ?>" id="kt_login_forgot" class="text-muted text-hover-primary">Lupa Password ?</a>
                            </div>

                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold py-4 my-3 btn-block">Log In</button>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</div>
<!--end::Login Sign in form-->

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