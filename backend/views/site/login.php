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
                    <div class="card-body">
                        <div class="mb-12">
                            <h3>Food Reservation</h3>
                            <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
                        </div>
                        <?php $form = ActiveForm::begin(['id' => 'kt_login_signin_form', 'class' => 'form']); ?>

                            <div class="form-group mb-5">
                            <?= $form->field($model, 'username')->textInput([
                                'autofocus' => true,
                                'class' => 'form-control h-auto form-control-solid py-4 px-8',
                                'placeholder' => 'username',
                                'autocomplete' => 'off',
                            ])->label(false) ?>
                            </div>

                            <div class="form-group mb-5">
                            <?= $form->field($model, 'password')->passwordInput([
                                'class' => 'form-control h-auto form-control-solid py-4 px-8',
                                'placeholder' => 'password',
                            ])->label(false) ?>
                            </div>

                            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                <div class="checkbox-inline d-none">
                                    <label class="checkbox m-0 text-muted">
                                    <input type="checkbox" name="remember" />
                                    <span></span>Remember me</label>
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
