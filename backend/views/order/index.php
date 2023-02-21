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

<div class="card card-custom rounded-lg bg-primary text-white mb-8">
    <div class="card-body">
        <table width="100%">
        <tr class="row">
            <td width="100px" style="padding-right: 16px;">
                <?= Html::img(Yii::getAlias('@web/img/user.jpg'), ['class' => 'rounded-circle', 'width' => '100%']) ?>
            </td>
            <td style="vertical-align:middle">
                <big><b><?= Yii::$app->user->identity->name ?></b></big>
                <br><?= Yii::$app->user->identity->email ?>
                <div></div>
                <br><span class="label label-inline font-weight-bold text-primary mb-0"><big><?= Yii::$app->user->identity->unit->name ?></big></span>
                <br><?= Yii::$app->user->identity->subunit ?></span>
            </td>
        </tr>
        </table>
    </div>
</div>

<div class="row">

    <?php $schedules = Schedule::find()->where([
        'and',
        ['<=', 'datetime_start_order', date('Y-m-d H:i:s')],
        ['>=', 'date', date('Y-m-d')],
    ])->orderBy('date DESC')->all(); ?>
    <?php foreach ($schedules as $model) { ?>
        <div class="col-md-12 col-lg-6">
            <div class="card card-custom rounded-lg mb-8">
                <div class="card-body">
                    <div class="mt-0">
                        <b class="font-size-lg"><?= date('d F Y', strtotime($model->date)) ?></b><br><span><?= $model->shift->name.' '.$model->description ?></span>
                    </div>
                    <?php $order = Order::find()->where(['schedule_id' => $model->id, 'user_id' => Yii::$app->user->id])->one() ?>
                    <div class="alert p-0 my-4 bg-light text-center">
                        <?php if ($order) { ?>
                            <div class="image-container mb-4">
                                <?= Html::img(['/menu/download', 'id' => $order->menu_id], ['width' => '100%', 'class' => 'rounded border img img-responsive full-width bg-secondary']) ?>
                            </div>
                            <h5 class="mb-4"><?= $order->menu->name ?></h5>
                        <?php } ?>
                        <?php if (!$order) echo '<i>belum memesan</i>' ?>
                    </div>
                    <?= ($model->datetime_end_order > date('Y-m-d H:i:s')) ? Html::button($order ? 'Ganti Pesanan' : 'Tentukan Pesanan', [
                        'value'     => Url::to(['set-order', 'schedule_id' => $model->id]),
                        'title'     => $order ? 'Ganti Pesanan' : 'Tentukan Pesanan',
                        'class'     => 'showModalButton btn btn-light-primary',
                        'size'      => 'modal-lg',
                        'data-pjax' => 0,
                    ]) : '' ?>
                    <div class="float-right"><button class="btn btn-flat">&nbsp;</button> <?= $order ? $order->reviewStatusHtml : '' ?></div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (!$schedules) { ?>
        <div class="col-md-12 col-lg-12">
            <div class="card card-custom rounded-lg">
                <div class="card-body text-center text-muted">
                    belum ada pemesanan makanan tersedia.
                </div>
            </div>
        </div>
    <?php } ?>

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