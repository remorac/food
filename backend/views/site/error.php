<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
if (Yii::$app->user->isGuest) $this->context->layout = 'guest/main';
?>
<div class="site-error">

    <h1><?php if (Yii::$app->user->isGuest) echo Html::encode($this->title) ?></h1>

    <div class="alert alert-custom alert-light-danger font-weight-bold">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
        <br>Please contact webmaster if you think this is a server error. Thank you.
    </p>
    <br>

    <?= Html::a('<i class="fa fa-arrow-left"></i> Back', ['/'], [
        'class' => 'btn btn-primary'
    ]) ?>

</div>
