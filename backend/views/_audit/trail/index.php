<?php

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;

use bedezign\yii2\audit\models\AuditTrailSearch;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Trails');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
?>
<div class="audit-trail">

    <?php $exportColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['class' => 'text-right serial-column'],
            'contentOptions' => ['class' => 'text-right serial-column'],
        ],
        [
            'class' => 'yii\grid\ActionColumn', 
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url) {
                    return Html::a('', $url, ['class' => 'glyphicon glyphicon-eye-open btn btn-xs btn-default btn-text-info']);
                },
            ],
        ],
        'id',
        [
            'attribute' => 'entry_id',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'user_id',
            'label' => Yii::t('audit', 'User ID'),
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return Audit::getInstance()->getUserIdentifier($data->user_id);
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'action',
            'filter' => AuditTrailSearch::actionFilter(),
        ],
        'model',
        'model_id',
        'field',
        [
            'label' => Yii::t('audit', 'Diff'),
            'value' => function ($model) {
                return $model->getDiffHtml();
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'created',
            'options' => ['width' => '150px'],
        ],
    ]; ?>

    <?php $exportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns'      => $exportColumns,
        'filename'     => 'User',
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
        'pjaxContainerId' => 'grid',
    ]); ?>

    <?= GridView::widget([
        'dataProvider'     => $dataProvider,
        'filterModel'      => $searchModel,
        'responsiveWrap'   => false,
        'pjax'             => true,
        'hover'            => true,
        'striped'          => false,
        'bordered'         => false,
        'pjaxSettings'     => ['options' => ['id' => 'grid']],
        'headerRowOptions' => ['class' => 'thead-light'],
        'toolbar'          => [
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
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-right serial-column'],
                'contentOptions' => ['class' => 'text-right serial-column'],
            ],
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class="fas fa-eye">', $url, ['class' => 'btn btn-xs btn-icon btn-light-info']);
                    },
                ],
            ],
            'id',
            [
                'attribute' => 'entry_id',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'label' => Yii::t('audit', 'User ID'),
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return Audit::getInstance()->getUserIdentifier($data->user_id);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'action',
                'filter' => AuditTrailSearch::actionFilter(),
            ],
            'model',
            'model_id',
            'field',
            [
                'label' => Yii::t('audit', 'Diff'),
                'value' => function ($model) {
                    return $model->getDiffHtml();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created',
                'options' => ['width' => '150px'],
            ],
        ],
    ]); ?>
</div>
