<?php

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use kartik\grid\GridView;

use bedezign\yii2\audit\models\AuditEntrySearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Entries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
?>
<div class="audit-entry-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

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
                'attribute' => 'user_id',
                'label' => Yii::t('audit', 'User'),
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return Audit::getInstance()->getUserIdentifier($data->user_id);
                },
                'format' => 'raw',
            ],
            'ip',
            [
                'filter' => AuditEntrySearch::methodFilter(),
                'attribute' => 'request_method',
            ],
            [
                'filter' => [1 => \Yii::t('audit', 'Yes'), 0 => \Yii::t('audit', 'No')],
                'attribute' => 'ajax',
                'value' => function($data) {
                    return $data->ajax ? Yii::t('audit', 'Yes') : Yii::t('audit', 'No');
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'route',
                'filter' => AuditEntrySearch::routeFilter(),
                'format' => 'html',
                'value' => function ($data) {
                    return HTML::tag('span', '', [
                        'title' => \yii\helpers\Url::to([$data->route]),
                        'class' => 'glyphicon glyphicon-link'
                    ]) . ' ' . $data->route;
                },
            ],
            [
                'attribute' => 'duration',
                'format' => 'decimal',
                'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
            ],
            [
                'attribute' => 'memory_max',
                'format' => 'shortsize',
                'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
            ],
            [
                'attribute' => 'trails',
                'value' => function ($data) {
                    return $data->trails ? count($data->trails) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'mails',
                'value' => function ($data) {
                    return $data->mails ? count($data->mails) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'javascripts',
                'value' => function ($data) {
                    return $data->javascripts ? count($data->javascripts) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'errors',
                'value' => function ($data) {
                    return $data->linkedErrors ? count($data->linkedErrors) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'created',
                'options' => ['width' => '150px'],
            ],
        ],
    ]); ?>
</div>
