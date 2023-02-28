<?php

/* @var $this yii\web\View */

use common\models\entity\Schedule;
use yii\helpers\Html;

$this->title = '';
?>

<?php
$schedulesOpen = Schedule::find()->where([
    'and',
    ['<=', 'datetime_start_order', date('Y-m-d H:i:s')],
    ['>=', 'datetime_end_order', date('Y-m-d H:i:s')],
])->all();
$schedulesClosed = Schedule::find()->where([
    'and',
    ['<=', 'datetime_end_order', date('Y-m-d H:i:s')],
    ['>=', 'date', date('Y-m-d')],
])->all();
?>

<h2 class="mb-8">Pemesanan Sedang Dibuka</h2>

<div class="row">
    <?php foreach ($schedulesOpen as $schedule) { ?>
        <?php 
            $menuCssClass = 'danger';
            $menuLabel    = 'BELUM ADA MENU';
            $count        = count($schedule->scheduleMenus);
            if ($count) {
                $menuCssClass = 'success';
                $menuLabel    = $count.' JENIS MENU';
            } 
        ?>
        <div class="col-md-6">
            <div class="card card-custom mb-8">
                <div class="card-body">
                    <h4 class="mt-0 text-success">
                        <?= $schedule->date ?> <?= $schedule->shift->name ?>
                        <br><span class="label label-inline label-<?= $menuCssClass ?>"><?= $menuLabel ?></span>
                    </h4>
                    <br>Pemesanan sedang berlangsung mulai <?= $schedule->datetime_start_order ?>
                    hingga <?= $schedule->datetime_end_order ?>.
                    <br>Telah dipesan oleh XXX dari XXX orang.
                </div>
                <div class="card-footer text-right">
                    <?= Html::a('Lihat Detail', ['/schedule/view', 'id' => $schedule->id], ['class' => 'btn btn-light-primary']) ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<br>
<br>
<h2 class="mb-8">Pemesanan Sudah Ditutup</h2>

<div class="row">
    <?php foreach ($schedulesClosed as $schedule) { ?>
        <?php 
            $menuCssClass = 'danger';
            $menuLabel    = 'BELUM ADA MENU';
            $count        = count($schedule->scheduleMenus);
            if ($count) {
                $menuCssClass = 'success';
                $menuLabel    = $count.' JENIS MENU';
            } 
        ?>
        <div class="col-md-6">
            <div class="card card-custom mb-8">
                <div class="card-body">
                    <h4 class="mt-0 text-danger">
                        <?= $schedule->date ?> <?= $schedule->shift->name ?>
                        <br><span class="label label-inline label-<?= $menuCssClass ?>"><?= $menuLabel ?></span>
                    </h4>
                    <br>Pemesanan sudah ditutup pada <?= $schedule->datetime_end_order ?>.
                    <br>Telah dipesan oleh XXX dari XXX orang.
                </div>
                <div class="card-footer text-right">
                    <?= Html::a('Lihat Detail', ['/schedule/view', 'id' => $schedule->id], ['class' => 'btn btn-light-primary']) ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>