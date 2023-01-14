<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-view">

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
            'name',
            // 'type:integer',
            'description:ntext',
            [
                'attribute'      => 'is_active_sunday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_sunday),
            ],
            [
                'attribute'      => 'is_active_monday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_monday),
            ],
            [
                'attribute'      => 'is_active_tuesday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_tuesday),
            ],
            [
                'attribute'      => 'is_active_wednesday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_wednesday),
            ],
            [
                'attribute'      => 'is_active_thursday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_thursday),
            ],
            [
                'attribute'      => 'is_active_friday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_friday),
            ],
            [
                'attribute'      => 'is_active_saturday',
                'format'         => 'html',
                'value'          => isActiveHtml($model->is_active_saturday),
            ],
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>
    
</div>
