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
])->orderBy('date, shift_id')->all();
$schedulesClosed = Schedule::find()->where([
    'and',
    ['<=', 'datetime_end_order', date('Y-m-d H:i:s')],
    ['>=', 'date', date('Y-m-d')],
])->orderBy('date, shift_id')->all();
?>

<h2 class="mb-8">Pemesanan yang Sedang Dibuka</h2>
<?php if (!$schedulesOpen) echo '<div class="alert alert-white mb-8">belum ada data.</div>'; ?>

<div class="row">
    <?php foreach ($schedulesOpen as $schedule) { ?>
        <div class="col-md-6">
            <div class="card card-custom mb-8">
                <div class="card-body">
                    <h4 class="mt-0 <?= $schedule->titleCssClass ?>">
                        <?= $schedule->shortText ?>
                        <br><?= $schedule->menuBadge ?>
                    </h4>
                    <br>Pemesanan sedang berlangsung mulai <?= $schedule->datetime_start_order ?>
                    hingga <?= $schedule->datetime_end_order ?>.
                    <br>Telah dipesan oleh <?= count($schedule->orders) ?> dari <?= $schedule->getEligibleUsersCount() ?> orang.
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
<h2 class="mb-8">Pemesanan yang Sudah Ditutup</h2>
<?php if (!$schedulesClosed) echo '<div class="alert alert-white mb-8">belum ada data.</div>'; ?>

<div class="row">
    <?php foreach ($schedulesClosed as $schedule) { ?>
        <div class="col-md-6">
            <div class="card card-custom mb-8">
                <div class="card-body">
                    <h4 class="mt-0 <?= $schedule->titleCssClass ?>">
                        <?= $schedule->shortText ?>
                        <br><?= $schedule->menuBadge ?>
                    </h4>
                    <br>Pemesanan sudah ditutup pada <?= $schedule->datetime_end_order ?>.
                    <br>Telah dipesan oleh <?= count($schedule->orders) ?> dari <?= $schedule->getEligibleUsersCount() ?> orang.
                </div>
                <div class="card-footer text-right">
                    <?= Html::a('Lihat Detail', ['/schedule/view', 'id' => $schedule->id], ['class' => 'btn btn-light-primary']) ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>