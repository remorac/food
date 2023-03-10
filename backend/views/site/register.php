<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'guest/main';
?>

<!--begin::Login Sign up form-->
<div class="login-signup">
    <div class="mb-20">
        <h3>Sign Up</h3>
        <div class="text-muted font-weight-bold">Enter your details to create your account</div>
    </div>
    <form class="form" id="kt_login_signup_form">
        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Fullname" name="fullname" />
        </div>
        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
        </div>
        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
        </div>
        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" />
        </div>
        <div class="form-group mb-5 text-left">
            <div class="checkbox-inline">
                <label class="checkbox m-0">
                <input type="checkbox" name="agree" />
                <span></span>I Agree the
                <a href="#" class="font-weight-bold ml-1">terms and conditions</a>.</label>
            </div>
            <div class="form-text text-muted text-center"></div>
        </div>
        <div class="form-group d-flex flex-wrap flex-center mt-10">
            <button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
            <button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
        </div>
    </form>
</div>
<!--end::Login Sign up form-->