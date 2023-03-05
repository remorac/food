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
        <tr class="">
            <td width="100px" style="vertical-align:top; padding-right: 16px;">
                <?= Html::img(Yii::getAlias('@web/img/user.jpg'), ['class' => 'rounded-circle', 'width' => '100%']) ?>
            </td>
            <td style="vertical-align:middle">
                <big><b><?= Yii::$app->user->identity->name ?></b></big>
                <br><?= Yii::$app->user->identity->email ?>
                <br>&nbsp;
                <div class="card card-custom rounded-lg bg-light-primary text-primary w-100 mb-0">
                    <div class="card-body p-4">
                        <span class="label label-inline label-primary font-weight-bold mb-2"><big><?= Yii::$app->user->identity->unit->name ?></big></span>
                        <br><span class="font-weight-bold"><?= strtoupper(Yii::$app->user->identity->subunit) ?></span>
                        <br><span class="font-size-sm"><?= strtoupper(Yii::$app->user->identity->position) ?></span>
                        <br><span class="font-size-sm"><?= Yii::$app->user->identity->group ? 'Shift (Regu '.strtoupper(Yii::$app->user->identity->group->name).')' : 'Non Shift' ?></span>
                    </div>
                </div>
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
    ])->orderBy('date, shift_id')->all(); ?>
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
                        <?php if (!$order) echo '<div class="m-4"><i>belum memesan</i></div>' ?>
                    </div>
                    <?= ($model->datetime_end_order > date('Y-m-d H:i:s')) ? Html::button($order ? 'Ganti Pesanan' : 'Tentukan Pesanan', [
                        'value'     => Url::to(['set-order', 'schedule_id' => $model->id]),
                        'title'     => $order ? 'Ganti Pesanan' : 'Tentukan Pesanan',
                        'class'     => 'showModalButton btn btn-light-primary',
                        'size'      => 'modal-lg',
                        'data-pjax' => 0,
                    ]) : '' ?>
                    <?= ($model->datetime_end_order > date('Y-m-d H:i:s') && $order) ? Html::a('Batalkan Pesanan', ['delete', 'id' => $order->id], [
                        'class'        => 'btn btn-light-danger',
                        'data-confirm' => 'Batalkan pesanan ini?',
                        'data-method'  => 'post',
                        'data-pjax'    => 0,
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