<?php

use common\models\entity\User;
use common\models\search\UserSearch;
use common\models\search\UserSearchUnit;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Unit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Unit Kerja', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="unit-view">

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
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">User</div>
        </div>
        <div class="card-body">
            <?php
                $searchModel = new UserSearchUnit();
                $queryParams = Yii::$app->request->queryParams;
                $queryParams['UserSearchUnit']['unit_id'] = $model->id;
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
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class'     => 'btn btn-icon btn-xs btn-light-info',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fas fa-pen"></i>', [
                                    'value'     => Url::to(['user-update', 'user_id' => $model->id]),
                                    'title'     => 'Update',
                                    'class'     => 'showModalButton btn btn-icon btn-xs btn-light-warning',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', ['user-delete', 'user_id' => $model->id], [
                                    'class'        => 'btn btn-icon btn-xs btn-light-danger',
                                    'data-method'  => 'post',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-pjax'    => 0,
                                ]);
                            },
                        ],
                    ],
                    // 'id',
                    // 'phone',
                    'email:email',
                    'name',
                    [
                        'attribute'           => 'status',
                        'format'              => 'html',
                        'value'               => 'statusHtml',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => User::statuses(),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    /* [
                        'attribute'           => 'unit_id',
                        'value'               => 'unit.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Unit::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute'           => 'supplier_id',
                        'value'               => 'supplier.name',
                        'filterType'          => GridView::FILTER_SELECT2,
                        'filter'              => ArrayHelper::map(Supplier::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterInputOptions'  => ['placeholder' => '. . .'],
                        'filterWidgetOptions' => [
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ], */
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
                    Html::button('<i class="fas fa-plus"></i>', [
                        'value' => Url::to(['user-create', 'id' => $model->id]), 
                        'title' => 'Create User', 
                        'class' => 'showModalButton btn btn-icon btn-success'
                    ]),
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
