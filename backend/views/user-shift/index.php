<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\entity\User;
use common\models\entity\Shift;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserShiftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perubahan Jadwal Shift Individu';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-shift-index">

    <?php 
        $exportColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'user.name:text:User',
            'date:date',
            'shift.name:text:Shift',
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.username:text:Created By',
            'updatedBy.username:text:Updated By',
        ];

        $exportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'      => $exportColumns,
            'filename'     => 'User Shift',
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
                'attribute'           => 'user_id',
                'value'               => 'user.shortText',
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => ArrayHelper::map(User::find()->where(['is not', 'unit_id', null])->orderBy('name')->all(), 'id', 'shortText'),
                'filterInputOptions'  => ['placeholder' => '. . .'],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_DEFAULT,
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
            [
                'attribute'           => 'date',
                'format'              => 'date',
                'filterType'          => GridView::FILTER_DATE,
                'filterInputOptions'  => ['placeholder' => ''],
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
                ],
            ],
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
