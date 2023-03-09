<?php

use common\models\entity\Location;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
use common\models\entity\Schedule;
use common\models\entity\User;
use common\models\entity\Menu;
use common\models\entity\MenuAvailability;
use common\models\entity\ScheduleMenu;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Html::button('<i class="fa fa-arrow-left"></i> Kembali', ['class' => 'btn btn-secondary float-right', 'data-dismiss' => 'modal']) ?>

<?php 
    // $field = 'is_active_'.strtolower(date('l', strtotime($model->schedule->date)));
    $menus = Menu::find()->orderBy('name')->all();
    $scheduleMenus = ScheduleMenu::find()->joinWith(['menu'])->where(['schedule_id' => $model->schedule_id])->orderBy('menu.name')->all();
?>

<?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="order-form">
    
    <div class="mt-0 mb-6">
        <b class="font-size-lg"><?= date('d F Y', strtotime($model->schedule->date)) ?></b>
        <br><span><?= $model->schedule->shift->name ?></span>
        <br><span class="text-muted"><?= $model->schedule->description ?></span>
    </div>

    <?= '' /*  $form->field($model, 'menu_id')->widget(Select2::class, [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Menu::find()->where([$field => 1])->all(), 'id', 'name'),
        'options' => ['placeholder' => '. . .'],
        'pluginOptions' => ['allowClear' => true],
    ])->label('Pilih Menu'); */ ?>

    <p class="text-muted">
        Permintaan Anda akan ditinjau terlebih dahulu oleh admin atau koperasi.
    </p>

    <div class="form-group">
        <label>Lokasi Pengantaran</label>
        <?= Select2::widget([
            'name' => 'location_id',
            'value' => $model->location_id,
            'data' => ArrayHelper::map(Location::find()->asArray()->all(), 'id', 'name'),
            'theme' => Select2::THEME_DEFAULT,
            'options' => ['placeholder' => '. . .', 'required' => true],
            'pluginOptions' => ['allowClear' => true],
        ]) ?>
    </div>

    <div class="row">
        <?php /* foreach ($menus as $menu) { ?>
            <?php if (Menu::isAvailable($menu->id, $model->schedule->date, $model->schedule->shift_id, $model->schedule_id)) { ?>
                <div class="col-6">
                    <div class="alert p-0 my-4 bg-light text-center">
                        <div class="image-container mb-4">
                            <?= Html::img(['/menu/download', 'id' => $menu->id], ['width' => '100%', 'class' => 'rounded border img img-responsive full-width bg-secondary']) ?>
                        </div>
                        <h5><?= $menu->name ?></h5>
                        <p><?= $menu->description ?></p>
                        <div class="p-4">
                        <?= Html::a('<i class="fa fa-check"></i> Pilih', ['order/set', 'schedule_id' => $model->schedule_id, 'menu_id' => $menu->id], [
                            'class' => 'btn btn-primary btn-block',
                            'data-method' => 'post',
                        ]) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } */ ?>

        <?php foreach ($scheduleMenus as $scheduleMenu) { ?>
            <?php if (Menu::isAvailable($scheduleMenu->menu->id, $model->schedule->date, $model->schedule->shift_id, $model->schedule_id)) { ?>
                <div class="col-6">
                    <div class="alert p-0 my-4 bg-light text-center">
                        <div class="image-container mb-4">
                            <?= Html::img(['/menu/download', 'id' => $scheduleMenu->menu->id], ['width' => '100%', 'class' => 'rounded border img img-responsive full-width bg-secondary']) ?>
                        </div>
                        <h5><?= $scheduleMenu->menu->name ?></h5>
                        <p><?= $scheduleMenu->description ?></p>
                        <div class="p-4">
                        <?= Html::a('<i class="fa fa-check"></i> Pilih', ['order/set', 'schedule_id' => $model->schedule_id, 'menu_id' => $scheduleMenu->menu->id], [
                            'class' => 'btn btn-primary btn-block',
                            'data-method' => 'post',
                        ]) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <?php if (!$model->schedule->scheduleMenus) { ?>
        <div class="alert p-0 my-4 bg-light text-center">
            <div class="m-4"><i>belum ada menu tersedia.</i></div>
        </div>
    <?php } ?>

    <div class="modal-footer text-right">
        <?=  
            Html::button('<i class="fa fa-arrow-left"></i> Kembali', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) 
            //. ' ' . Html::submitButton('<i class="fa fa-check"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

</div>

<?php ActiveForm::end(); ?>

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