<?php

use bedezign\yii2\audit\Audit;
use bedezign\yii2\audit\components\panels\Panel;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Audit Module');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('canvas {width: 100% !important;height: 400px;}');
?>
<div class="audit-index">

    <div class="row">
        <div class="col-md-6 col-lg-12">
            <div class="card card-custom card-fit mb-10">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            <?php echo Html::a(Yii::t('audit', 'Entries'), ['entry/index']); ?>
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <?php

                    echo ChartJs::widget([
                        'type' => 'bar',
                        /* 'options' => [
                            'height' => '300px',
                        ], */
                        'clientOptions' => [
                            'legend' => ['display' => false],
                            'tooltips' => ['enabled' => false],
                        ],
                        'data' => [
                            'labels' => array_keys($chartData),
                            'datasets' => [
                                [
                                    'fillColor'        => 'rgba(151,187,205,0.5)',
                                    'strokeColor'      => 'rgba(151,187,205,1)',
                                    'pointColor'       => 'rgba(151,187,205,1)',
                                    'pointStrokeColor' => '#fff',
                                    'data'             => array_values($chartData),
                                ],
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <?php
        $i = 0;
        foreach (Audit::getInstance()->panels as $panel) {
            /** @var Panel $panel */
            $chart = $panel->getChart();
            if (!$chart) {
                continue;
            }
            $indexUrl = $panel->getIndexUrl();
            ?>
            <?= $i++ == 0 ? '<div class="col-md-6 col-lg-6">' : '<div class="col-md-4 col-lg-6">' ?>
            <!-- <div class="col-md-6 col-lg-6"> -->
            <div class="card card-custom card-fit mb-10">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            <?php echo $indexUrl ? Html::a($panel->getName(), $indexUrl) : $panel->getName(); ?>
                        </h3>
                    </div>
                </div>

                <div class="card-body">
                    <?php echo $chart; ?>
                </div>
            </div>
            </div>
        <?php } ?>

    </div>

</div>
