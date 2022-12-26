<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Log */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

$arr = explode('.', $model->log_time);
$arr[1] = isset($arr[1]) ? '.'.$arr[1] : '';
?>

<div class="log-view">

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
            [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-mono'],
            ],
            [
                'attribute' => 'level',
                'contentOptions' => ['class' => 'text-mono'],
                'value' => \yii\Log\Logger::getLevelName($model->level),
            ],
            [
                'attribute' => 'category',
                'contentOptions' => ['class' => 'text-mono'],
            ],
            [
                'attribute' => 'log_time',
                'value' => date('Y-m-d H:i:s'.$arr[1], $arr[0]),
                'contentOptions' => ['class' => 'text-mono'],
            ],
            [
                'attribute' => 'prefix',
                'format' => 'ntext',
                'contentOptions' => ['class' => 'text-mono'],
            ],
            [
                'attribute' => 'message',
                'format' => 'ntext',
                'contentOptions' => ['class' => 'text-mono'],
            ],
        ],
    ]) ?>
    
</div>
