<?php

use bedezign\yii2\audit\models\AuditMailSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel AuditMailSearch */

$this->title = Yii::t('audit', 'Mails');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-mail">

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
            [
                'attribute' => 'id',
                'options' => [
                    'width' => '80px',
                ],
            ],
            [
                'attribute' => 'entry_id',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'successful',
                'options' => [
                    'width' => '80px',
                ],
            ],
            'to',
            'from',
            'reply',
            'cc',
            'bcc',
            'subject',
            [
                'attribute' => 'created',
                'options' => ['width' => '150px'],
            ],
        ],
    ]); ?>
</div>
