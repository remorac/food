<?php

use common\models\entity\Menu;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-index">

    <?php 
        $exportColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'name',
            'type',
            'description',
            // 'is_active_sunday',
            // 'is_active_monday',
            // 'is_active_tuesday',
            // 'is_active_wednesday',
            // 'is_active_thursday',
            // 'is_active_friday',
            // 'is_active_saturday',
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.username:text:Created By',
            'updatedBy.username:text:Updated By',
        ];

        $exportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'      => $exportColumns,
            'filename'     => 'Menu',
            'fontAwesome'  => true,
            'asDropdown'   => false,
            'batchSize'    => 10,
            'target'       => ExportMenu::TARGET_SELF,
            'exportConfig' => [
                ExportMenu::FORMAT_CSV      => false,
                ExportMenu::FORMAT_EXCEL    => false,
                ExportMenu::FORMAT_HTML     => false,
                ExportMenu::FORMAT_TEXT     => false,
                ExportMenu::FORMAT_PDF      => false,
                ExportMenu::FORMAT_EXCEL_X  => [
                    'label'       => '',
                    'icon'        => 'fas fa-file-excel',
                    'linkOptions' => ['class' => 'btn btn-icon btn-white text-success'],
                    'options'     => ['style' => 'list-style:none; padding: 0; margin: 0;display: inline-block;'],
                ],
            ],
            'styleOptions' => [
                ExportMenu::FORMAT_EXCEL_X => [
                    'font' => ['color' => ['argb' => '00000000']],
                    'fill' => ['color' => ['argb' => 'DDDDDDDD']],
                ],
            ],
        ]);

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
                'attribute'      => 'file_image',
                'format'         => 'html',
                'value'  => function($model) {
                    return $model->file_image ? Html::img(['download', 'id' => $model->id], ['width' => '50px', 'height' => '50px', 'class' => 'rounded border']) : '';
                },
                'headerOptions' => ['class' => 'fit nowrap'],
                'contentOptions' => ['class' => 'fit nowrap'],
            ],
            'name',
            /* [
                'attribute'      => 'description',
                'format'         => 'ntext',
                'contentOptions' => ['class' => 'text-wrap'],
            ], */
            /* [
                'attribute' => 'quota',
                'format' => 'integer',
                'headerOptions' => ['class' => 'fit nowrap text-right'],
                'contentOptions' => ['class' => 'fit nowrap text-right'],
            ], */
            [
                'attribute'      => 'type',
                'format'         => 'html',
                'value'  => function($model) {
                    return $model->typeHtml;
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => Menu::types(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap'],
                'contentOptions' => ['class' => 'fit nowrap'],
            ],
            /* [
                'attribute'      => 'is_active_sunday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_sunday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_monday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_monday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_tuesday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_tuesday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_wednesday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_wednesday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_thursday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_thursday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_friday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_friday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ],
            [
                'attribute'      => 'is_active_saturday',
                'format'         => 'html',
                'value'          => function($model) { return isActiveHtml($model->is_active_saturday); },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => isActives(),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
                'headerOptions' => ['class' => 'fit nowrap text-center'],
                'contentOptions' => ['class' => 'fit nowrap text-center'],
            ], */
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
            Html::button('<i class="fas fa-plus"></i>', [
                'value' => Url::to(['create']), 
                'title' => 'Create', 
                'class' => 'showModalButton btn btn-icon btn-success'
            ]),
            Html::a('<i class="fas fa-undo"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-icon btn-white', 'title' => 'Reload']),
            '{toggleData}',
            // $exportMenu,
        ],
        'toggleDataOptions' => [
            'all'  => ['label' => false, 'class' => 'btn btn-icon btn-white'],
            'page' => ['label' => false, 'class' => 'btn btn-icon btn-white'],
        ],
        'layout' => '<div class="row">
            <div class="col toolbar">{toolbar}</div>
            <div class="col toolbar right align-self-end"><span class="float-right">{summary}</span></div>
        </div> {items} {pager}',
    ]); ?>

</div>
