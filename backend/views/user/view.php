<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\entity\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">

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
            // 'phone',
            'email:email',
            'name',
            'statusHtml:html:Status',
            // 'unit.name:text:Unit',
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'created_by:integer',
            // 'updated_by:integer',
        ],
    ]) ?>
    
</div>
