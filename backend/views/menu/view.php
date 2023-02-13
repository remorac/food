<?php

use common\models\entity\MenuAvailability;
use common\models\entity\Shift;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-view">

    <div class="toolbar">
        <?= Html::button('<i class="fas fa-pen"></i>', [
            'value' => Url::to(['update', 'id' => $model->id]), 
            'title' => 'Update', 
            'class' => 'showModalButton btn btn-icon btn-warning'
        ]); ?>
        <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-icon btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute'      => 'file_image',
                'format'         => 'html',
                'value'  => $model->file_image ? Html::img(['download', 'id' => $model->id], ['width' => '200px', 'height' => '200px', 'class' => 'rounded border']) : '',
            ],
            'name',
            /* [
                'attribute'      => 'description',
                'format'         => 'ntext',
                'contentOptions' => ['class' => 'text-wrap'],
            ], */
            // 'quota:integer',
            [
                'attribute'      => 'type',
                'format'         => 'html',
                'value'  => $model->typeHtml,
            ],
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>

    <div class="d-none">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'      => 'is_active_sunday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_sunday),
            ],
            [
                'attribute'      => 'is_active_monday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_monday),
            ],
            [
                'attribute'      => 'is_active_tuesday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_tuesday),
            ],
            [
                'attribute'      => 'is_active_wednesday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_wednesday),
            ],
            [
                'attribute'      => 'is_active_thursday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_thursday),
            ],
            [
                'attribute'      => 'is_active_friday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_friday),
            ],
            [
                'attribute'      => 'is_active_saturday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_saturday),
            ],
        ],
    ]) ?>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">Ketersediaan Mingguan</div>
        </div>
        <div class="card-body">
            <?php $day_of_weeks = range(0, 6) ?>
            <?php $shifts = Shift::find()->all() ?>
            <table width="100%">
                <tr>
                <?php foreach ($day_of_weeks as $day_of_week) { ?>
                    <td>
                        <div class="mb-2"><b><?= date('l', strtotime("Sunday +{$day_of_week} days")); ?></b></div>
                        <?php $menuAvailabilities = MenuAvailability::find()->where(['menu_id' => $model->id, 'day_of_week' => $day_of_week])->all() ?>
                        <?php foreach ($menuAvailabilities as $menuAvailability) { ?>
                            <?php if ($menuAvailability->quota == 0) $menuAvailability->quota = null ?>
                            <?= '' // Html::checkbox($menuAvailability->day_of_week.'-'.$menuAvailability->shift_id, false, ['label' => '&nbsp;'.$menuAvailability->shift->name]) ?>
                            <div class="mb-1">
                                <table>
                                    <tr>
                                        <td><?= Html::textInput($menuAvailability->day_of_week.'-'.$menuAvailability->shift_id, $menuAvailability->quota, ['style' => 'width:50px; height:28px', 'class' => 'form-control form-control-solid input-sm p-2 text-right']) ?></td>
                                        <td>&nbsp;<?= $menuAvailability->shift->name ?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                    </td>
                <?php } ?>
                </tr>
            </table>
        </div>
        <div class="card-footer text-right">
            <?= Html::resetButton('<i class="fa fa-undo"></i> Reset', ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton('<i class="fa fa-check"></i> Simpan', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
</div>
