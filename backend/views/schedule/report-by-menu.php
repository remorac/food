 
<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use common\models\entity\Customer;
use common\models\entity\Salesman;
use backend\helpers\ReportHelper;
use common\models\entity\Menu;
use common\models\entity\Order;
use common\models\entity\Unit;
use kartik\export\ExportMenu;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Outgoing */

$this->title = $title;
?>

<div class="printable">

    <?php if (!$model->ordersAccepted) { ?>
        <span class="text-muted">Tidak ada data.</span>
    <?php } else { ?>

        <?php $menus = Menu::find()->asArray()->all() ?>
        <?php foreach ($menus as $menu) { ?>
            <?php $menuAcceptedCount = Order::find()->where(['schedule_id' => $model->id, 'menu_id' => $menu['id']])->count(); ?>
            <?php if ($menuAcceptedCount) { ?>

                <table width="100%" class="table table-report-footer" style="margin-bottom: 8px;">
                    <tr>
                        <td style="padding:0"><b><?= $menu['name'] ?></b></td>
                        <td style="padding:0" class="text-right">Total Quantity: <b><?= $menuAcceptedCount ?></b></td>
                    </tr>
                </table>
                
                <div class="detail-view-container" style="border:2px solid #eee">
                    <table width="100%" class="table table-report" style="margin-bottom: -1px;">
                    <?php $units = Unit::find()->asArray()->all() ?>
                    <?php foreach ($units as $unit) { ?>
                        <?php $unitAcceptedCount = Order::find()->joinWith(['user'])->where(['schedule_id' => $model->id, 'unit_id' => $unit['id']])->count(); ?>
                        <?php if ($unitAcceptedCount) { ?>
                            <tr>
                                <td><?= $unit['name'] ?></td>
                                <td class="text-right"><?= $unitAcceptedCount ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </table>
                </div>

            <?php } ?>
        <?php } ?>

    <?php } ?>
    
</div>
