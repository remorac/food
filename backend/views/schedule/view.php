<?php

use common\models\entity\Menu;
use common\models\entity\Order;
use common\models\entity\Schedule;
use common\models\entity\ScheduleMenu;
use common\models\entity\Unit;
use common\models\entity\User;
use common\models\search\OrderSearch;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Schedule */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal', 'url' => ['index']];
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
            'date',
            [
                'attribute'           => 'shift_id',
                'value'               => $model->shift->name,
            ],
            'datetime_start_order',
            'datetime_end_order',
            'description',
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(['id' => 'active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">Menu</div>
            <div class="card-toolbar text-warning"></div>
        </div>
        <div class="card-body">
            <table>
                <?php $menus = Menu::find()->orderBy('name')->all(); ?>
                <?php foreach ($menus as $menu) { ?>
                    <?php $scheduleMenu = ScheduleMenu::findOne(['schedule_id' => $model->id, 'menu_id' => $menu->id]); ?>
                    <?php $menuCssClass = $scheduleMenu && $scheduleMenu->quota > 0 ? '' : 'text-muted' ?>
                    <tr>
                        <th class="pb-4 pr-8 <?= $menuCssClass ?>"><?= $menu->name ?></th>
                        <td class="pb-4"><?= Html::textInput('quota['.$menu->id.']', $menuCssClass ? '' : $scheduleMenu->quota, ['class' => 'form-control text-right']) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'data-confirm' => 'Perbarui menu untuk jadwal ini?']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php $countOrderWaiting = Order::find()->where([
        'schedule_id' => $model->id,
        'review_status' => 0,
    ])->count() ?>

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">Pemesanan</div>
            <div class="card-toolbar text-warning"><?= $countOrderWaiting ? 'Ada&nbsp;<b>'.$countOrderWaiting.'</b>&nbsp;pesanan belum direview' : '' ?></div>
        </div>
        <div class="card-body">
            <?php
                $searchModel = new OrderSearch();
                $queryParams = Yii::$app->request->queryParams;
                $queryParams['OrderSearch']['schedule_id'] = $model->id;
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
                        'template' => '{delete} {accept} {reject} {reset}',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', ['delete-order', 'order_id' => $model->id], [
                                    'class'        => 'btn btn-icon btn-xs btn-light-danger mr-4',
                                    'data-confirm' => 'Hapus pesanan ini?',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                            'reset' => function ($url, $model) {
                                return Html::a('<i class="fas fa-undo"></i>', ['reset', 'order_id' => $model->id], [
                                    'class'        => 'btn btn-icon btn-xs btn-secondary',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                            'accept' => function ($url, $model) {
                                return Html::a('<i class="fas fa-check"></i>', ['accept', 'order_id' => $model->id], [
                                    'class'        => 'btn btn-icon btn-xs btn-light-success',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                            'reject' => function ($url, $model) {
                                return Html::a('<i class="fas fa-times"></i>', ['reject', 'order_id' => $model->id], [
                                    'class'        => 'btn btn-icon btn-xs btn-light-danger',
                                    'data-method'  => 'post',
                                    'data-pjax'    => 0,
                                ]);
                            },
                        ],
                    ],
                    // 'id',
                    [
                        'label'               => 'Unit Kerja',
                        'attribute'           => 'unit_id',
                        'value'               => 'user.unit.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Unit::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'headerOptions'  => ['class' => 'fit nowrap'],
                        'contentOptions' => ['class' => 'fit nowrap'],
                    ],
                    [
                        'attribute'           => 'user_id',
                        'value'               => 'user.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(User::find()->where(['is not', 'unit_id', null])->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'headerOptions'  => ['class' => 'fit nowrap'],
                        'contentOptions' => ['class' => 'fit nowrap'],
                    ],
                    [
                        'attribute'           => 'menu_id',
                        'value'               => 'menu.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Menu::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    /* [
                        'attribute'           => 'schedule_id',
                        'value'               => 'scheduleMenu.schedule.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Schedule::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ], */
                    [
                        'attribute' => 'review_status',
                        'format'    => 'html',
                        'value'     => function($model) {
                            return $model->reviewStatusHtml;
                        },
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => Order::reviewStatuses(),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'headerOptions'  => ['class' => 'fit nowrap'],
                        'contentOptions' => ['class' => 'fit nowrap'],
                    ],
                    [
                        'attribute'      => 'reviewed_at',
                        'format'         => 'datetime',
                        'headerOptions'  => ['class' => 'fit nowrap'],
                        'contentOptions' => ['class' => 'fit nowrap'],
                    ],
                    [
                        'attribute' => 'reviewed_by',
                        'value'     => 'reviewedBy.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(User::find()->where(['unit_id' => null])->orderBy('id')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'headerOptions'  => ['class' => 'fit nowrap'],
                        'contentOptions' => ['class' => 'fit nowrap'],
                    ],
                    'eligibilityLabel:html:Status',
                    // 'created_at:integer',
                    // 'updated_at:integer',
                    // 'created_by:integer',
                    // 'updated_by:integer',
                ];
            ?>
        
            <?= GridView::widget([
                'dataProvider'     => $dataProvider,
                'filterModel'      => $searchModel,
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
                    Html::a('<i class="fas fa-check"></i> Setujui Semua', ['accept-all', 'id' => $model->id], [
                        'data-pjax' => 0, 
                        'data-method' => 'post', 
                        'data-confirm' => 'Setujui semua pesanan?', 
                        'class' => 'btn btn-light-success',
                    ]),
                    Html::a('<i class="fas fa-times"></i> Tolak Semua', ['reject-all', 'id' => $model->id], [
                        'data-pjax' => 0, 
                        'data-method' => 'post', 
                        'data-confirm' => 'Tolak semua pesanan?', 
                        'class' => 'btn btn-light-danger',
                    ]),
                    Html::a('<i class="fas fa-file-pdf"></i> Resume By Menu', ['report-by-menu', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'btn btn-light-info']),
                    Html::a('<i class="fas fa-file-pdf"></i> Resume by Unit Kerja', ['report-by-unit', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'btn btn-light-info']),
                ],
                'toggleDataOptions' => [
                    'all'  => ['label' => false, 'class' => 'btn btn-icon btn-secondary'],
                    'page' => ['label' => false, 'class' => 'btn btn-icon btn-secondary'],
                ],
                'layout' => '<div class="row">
                    <div class="col-10 toolbar">{toolbar}</div>
                    <div class="col-2 toolbar right align-self-end"><span class="float-right">{summary}</span></div>
                </div> {items} {pager}',
            ]); ?>
        </div>
    </div>
    
</div>
