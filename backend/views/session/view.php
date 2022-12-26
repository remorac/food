<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Session */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Session', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="session-view">

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
            'expire:datetime',
            'data',
            'user.name:text:User',
            'ip_address',
            'remote_addr',
            'http_x_forwarded_for',
            'http_user_agent',
            // 'created_at:datetime',
            // 'updated_at:datetime',
        ],
    ]) ?>
    
</div>
