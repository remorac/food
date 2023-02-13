<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
use common\models\entity\Schedule;
use common\models\entity\User;
use common\models\entity\Menu;
use common\models\entity\MenuAvailability;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    $field = 'is_active_'.strtolower(date('l', strtotime($model->schedule->datetime)));
    $menus = Menu::find()->where([$field => 1])->all();
?>

<div class="order-form">
    
    <div class="mt-0 mb-6">
        <b class="font-size-lg"><?= $model->schedule->name ?></b><br><span><?= date('d F Y H:i', strtotime($model->schedule->datetime)) ?></span>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= '' /*  $form->field($model, 'menu_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Menu::find()->where([$field => 1])->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ])->label('Pilih Menu'); */ ?>

    <p class="text-muted">
        Permintaan Anda akan ditinjau terlebih dahulu oleh admin atau koperasi.
    </p>

    <div class="modal-footer text-right d-none">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            . ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="row">
        <?php foreach ($menus as $menu) { ?>
            <?php if (Menu::isAvailable($menu->id, date('w', strtotime($model->schedule->datetime)), $model->schedule->shift_id)) { ?>
                <div class="col-6">
                    <div class="alert p-0 my-4 bg-light text-center">
                        <div class="image-container mb-4">
                            <?= Html::img(['/menu/download', 'id' => $menu->id], ['width' => '100%', 'class' => 'rounded border img img-responsive full-width bg-secondary']) ?>
                        </div>
                        <h5><?= $menu->name ?></h5>
                        <div class="p-4">
                        <?= Html::a('<i class="fa fa-check"></i> Pilih', ['order/set', 'schedule_id' => $model->schedule_id, 'menu_id' => $menu->id], [
                            'class' => 'btn btn-primary btn-block',
                            'data-method' => 'post',
                        ]) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

</div>

<style>
    .image-container {
        position:relative;
        overflow:hidden;
        padding-bottom:100%;
    }
    .image-container img {
        width: 100%; 
        height: 100%; 
        display: block; 
        object-fit: cover; 
        position: absolute;
    }
</style>