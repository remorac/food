<?php

use common\models\entity\Menu;
use common\models\entity\Supplier;
use common\models\search\MenuSearch;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Supplier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="supplier-view">

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
            'address',
            'phone',
            'is_active:integer',
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
            <?php
                $searchModel = new MenuSearch();
                $queryParams = Yii::$app->request->queryParams;
                $queryParams['MenuSearch']['supplier_id'] = $model->id;
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
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class'     => 'btn btn-icon btn-xs btn-light-info',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fas fa-pen"></i>', [
                                    'value'     => $url,
                                    'title'     => 'Update',
                                    'class'     => 'showModalButton btn btn-icon btn-xs btn-light-warning',
                                    'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function ($url) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class'        => 'btn btn-icon btn-xs btn-light-danger',
                                    'data-method'  => 'post',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-pjax'    => 0,
                                ]);
                            },
                        ],
                    ],
                    // 'id',
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
                    ],
                    'name',
                    [
                        'attribute'      => 'type',
                        'format'         => 'integer',
                        'headerOptions'  => ['class' => 'text-right'],
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute'      => 'description',
                        'format'         => 'ntext',
                        'contentOptions' => ['class' => 'text-wrap'],
                    ],
                    [
                        'attribute'      => 'is_active',
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
                    Html::button('<i class="fas fa-plus"></i>', [
                        'value' => Url::to(['menu-create', 'id' => $model->id]), 
                        'title' => 'Create Menu', 
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
