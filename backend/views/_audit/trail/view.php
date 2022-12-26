<?php

/** @var yii\web\View $this */
/** @var bedezign\yii2\audit\models\AuditTrail $model */

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('audit', 'Trail #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Trails'), 'url' => ['trail/index']];

?>

<div class="card card-custom border">
<?= DetailView::widget([
    'options' => ['class' => 'table detail-view'],
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => $model->getAttributeLabel('user_id'),
            'value' => Audit::getInstance()->getUserIdentifier($model->user_id),
            'format' => 'raw',
        ],
        [
            'attribute' => 'entry_id',
            'value' => $model->entry_id ? Html::a($model->entry_id, ['entry/view', 'id' => $model->entry_id]) : '',
            'format' => 'raw',
        ],
        'action',
        'model',
        'model_id',
        'field',
        'created',
    ],
]); ?>
</div>

<?php if ($model->getDiffHtml()) { ?>
    <div class="card card-custom border">
        <?= $model->getDiffHtml() ?>
    </div>
<?php } ?>
