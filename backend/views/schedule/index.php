<?php

use common\models\entity\Shift;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jadwal';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="schedule-index">

    <?php 
        $exportColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'name',
            'shift_id',
            'datetime',
            'datetime_start_order',
            'datetime_end_order',
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.username:text:Created By',
            'updatedBy.username:text:Updated By',
        ];

        $exportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'      => $exportColumns,
            'filename'     => 'Schedule',
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
            'date',
            [
                'attribute'           => 'shift_id',
                'value'               => 'shift.name',
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => ArrayHelper::map(Shift::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
            'datetime_start_order',
            'datetime_end_order',
            'description',
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
            Html::button('<i class="fas fa-plus"></i> Generate Jadwal', [
                'value' => Url::to(['generate']), 
                'title' => 'Generate Jadwal', 
                'class' => 'showModalButton btn btn-success',
            ]),
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
