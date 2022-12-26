<?php

use common\models\entity\Reservation;
use common\models\entity\Schedule;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use common\models\entity\User;
use common\models\entity\ScheduleMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReservationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pemesanan';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="reservation-index">

    <?php $schedules = Schedule::find()->all(); ?>
    <?php foreach ($schedules as $model) { ?>
        <div class="card card-custom">
            <div class="card-body">
                <h4 class="mt-0">
                    <?= $model->name ?>
                </h4>
                <?php $reservation = Reservation::find()->joinWith(['scheduleMenu'])->where(['schedule_id' => $model->id, 'user_id' => Yii::$app->user->id])->one() ?>
                <?= $reservation ? $reservation->scheduleMenu->shortText : '-' ?>
                <br><?= Html::button('Tentukan Pesanan', [
                    'value'     => Url::to(['set-reservation', 'schedule_id' => $model->id]),
                    'title'     => 'Update',
                    'class'     => 'showModalButton btn btn-light-primary mt-4',
                    'data-pjax' => 0,
                ])?>
            </div>
        </div>
    <?php } ?>

</div>
