<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use common\models\entity\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Session';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="session-index">

    <?php 
        $exportColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'expire',
            'data',
            'user.name:text:User',
            'ip_address',
            'remote_addr',
            'http_x_forwarded_for',
            'http_user_agent',
            'created_at:datetime',
            'updated_at:datetime',
        ];

        $exportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'      => $exportColumns,
            'filename'     => 'Session',
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
                'attribute'      => 'expire',
                'format'         => 'datetime',
                'headerOptions'  => ['class' => 'text-right'],
                'contentOptions' => ['class' => 'text-right'],
            ],
            'data',
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
            'ip_address',
            'remote_addr',
            'http_x_forwarded_for',
            'http_user_agent',
            // 'created_at:integer',
            // 'updated_at:integer',
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
