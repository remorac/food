<?php
use common\models\entity\Order;
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
/* @var $searchModel common\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pemesanan';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-custom rounded-lg bg-primary text-white">
    <div class="card-body">
        <table width="100%">
        <tr class="row">
            <td width="100px" style="padding-right: 16px;">
                <?= Html::img(Yii::getAlias('@web/img/user.jpg'), ['class' => 'rounded-circle', 'width' => '100%']) ?>
            </td>
            <td style="vertical-align:middle">
                <big><b><?= Yii::$app->user->identity->name ?></b></big>
                <br><?= Yii::$app->user->identity->email ?>
                <br>
                <br><span class="label label-inline font-weight-bold text-primary"><big><?= Yii::$app->user->identity->unit->name ?><big></span>
            </td>
        </tr>
        </table>
    </div>
</div>

<div class="order-index">

    <?php $schedules = Schedule::find()->where([
        'and',
        ['<=', 'datetime_start_order', date('Y-m-d H:i:s')],
        ['>=', 'datetime_end_order', date('Y-m-d H:i:s')],
    ])->all(); ?>
    <?php foreach ($schedules as $model) { ?>
        <div class="card card-custom rounded-lg">
            <div class="card-body">
                <div class="mt-0">
                    <b class="font-size-lg"><?= $model->name ?></b><br><span><?= date('d F Y H:i', strtotime($model->datetime)) ?></span>
                </div>
                <?php $order = Order::find()->where(['schedule_id' => $model->id, 'user_id' => Yii::$app->user->id])->one() ?>
                <div class="alert p-8 my-4 bg-light font-size-h4"><?= $order ? $order->menu->name : '-' ?></div>
                <?= Html::button('Tentukan Pesanan', [
                    'value'     => Url::to(['set-order', 'schedule_id' => $model->id]),
                    'title'     => 'Tentukan Pesanan',
                    'class'     => 'showModalButton btn btn-light-primary',
                    'data-pjax' => 0,
                ])?>
                <div class="float-right"><?= $order ? $order->reviewStatusHtml : '' ?></div>
            </div>
        </div>
    <?php } ?>

    <?php if (!$schedules) { ?>
        <div class="card card-custom rounded-lg">
            <div class="card-body text-center text-muted">
                belum ada pemesanan makanan tersedia.
            </div>
        </div>
    <?php } ?>

</div>
