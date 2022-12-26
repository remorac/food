<?php

use common\models\entity\Menu;
use common\models\entity\Schedule;
use common\models\entity\ScheduleMenu;
use common\models\entity\Supplier;
use common\models\entity\User;
use common\models\search\ReservationSearch;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Schedule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Schedule', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="schedule-view">

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
            'name',
            'datetime_start',
            'datetime_end',
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">Menu</div>
        </div>
        <div class="card-body">
            <?php $suppliers = Supplier::find()->all(); ?>
            <?php foreach ($suppliers as $supplier) { ?>
                <div class="card card-custom border">
                    <div class="card-body">
                        <h5 class="mt-0 mb-4"><?= $supplier->name ?></h5>
                        <?php $menus = Menu::findAll(['supplier_id' => $supplier->id, 'is_active' => 1]) ?>
                        <?php foreach ($menus as $menu) { ?>
                            <?= Html::checkbox($menu->id, false, ['label' => '&nbsp;'.$menu->name]) ?><br>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Select All', ['generate-schedule-menu', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">Pemesanan</div>
        </div>
        <div class="card-body">
            <?php
                $searchModel = new ReservationSearch();
                $queryParams = Yii::$app->request->queryParams;
                $queryParams['ReservationSearch']['schedule_id'] = $model->id;
                $dataProvider = $searchModel->search($queryParams);

                $gridColumns = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-right serial-column'],
                        'contentOptions' => ['class' => 'text-right serial-column'],
                    ],
                    [
                        'contentOptions' => ['class' => 'action-column nowrap text-left'],
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{accept} {reject} {reset}',
                        'buttons' => [
                            'reset' => function ($url) {
                                return Html::a('<i class="fas fa-undo"></i>', $url, [
                                    'class'        => 'btn btn-icon btn-xs btn-secondary',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                            'accept' => function ($url) {
                                return Html::a('<i class="fas fa-check"></i>', $url, [
                                    'class'        => 'btn btn-icon btn-xs btn-light-success',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                            'reject' => function ($url) {
                                return Html::a('<i class="fas fa-times"></i>', $url, [
                                    'class'        => 'btn btn-icon btn-xs btn-light-danger',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                        ],
                    ],
                    // 'id',
                    [
                        'attribute'           => 'user_id',
                        'value'               => 'user.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(User::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute'           => 'schedule_id',
                        'value'               => 'scheduleMenu.schedule.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Schedule::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute'           => 'schedule_menu_id',
                        'value'               => 'scheduleMenu.menu.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(ScheduleMenu::find()->orderBy('id')->all(), 'id', 'shortText'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute'      => 'review_status',
                        'format'         => 'integer',
                        'headerOptions'  => ['class' => 'text-right'],
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute'      => 'reviewed_at',
                        'format'         => 'integer',
                        'headerOptions'  => ['class' => 'text-right'],
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute'      => 'reviewed_by',
                        'format'         => 'integer',
                        'headerOptions'  => ['class' => 'text-right'],
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    // 'created_at:integer',
                    // 'updated_at:integer',
                    // 'created_by:integer',
                    // 'updated_by:integer',
                ];
            ?>
        
            <?= GridView::widget([
                'dataProvider'     => $dataProvider,
                // 'filterModel'      => $searchModel,
                'columns'          => $gridColumns,
                'responsiveWrap'   => false,
                'pjax'             => true,
                'hover'            => true,
                'striped'          => false,
                'bordered'         => false,
                'pjaxSettings'     => ['options' => ['id' => 'grid']],
                'headerRowOptions' => ['class' => 'thead-light'],
                'toolbar'          => [
                    /* Html::button('<i class="fas fa-plus"></i>', [
                        'value' => Url::to(['menu-create', 'id' => $model->id]), 
                        'title' => 'Create Menu', 
                        'class' => 'showModalButton btn btn-icon btn-success'
                    ]), */
                    Html::a('<i class="fas fa-undo"></i>', ['view', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'btn btn-icon btn-secondary', 'title' => 'Reload']),
                    '{toggleData}',
                    // $exportMenu,
                ],
                'toggleDataOptions' => [
                    'all'  => ['label' => false, 'class' => 'btn btn-icon btn-secondary'],
                    'page' => ['label' => false, 'class' => 'btn btn-icon btn-secondary'],
                ],
                'layout' => '<div class="row">
                    <div class="col toolbar">{toolbar}</div>
                    <div class="col toolbar right align-self-end"><span class="float-right">{summary}</span></div>
                </div> {items} {pager}',
            ]); ?>
        </div>
    </div>
    
</div>
