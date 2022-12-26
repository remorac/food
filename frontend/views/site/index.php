<?php

/* @var $this yii\web\View */

use common\models\entity\Blog;
use common\models\entity\Objective;
use common\models\entity\Slideshow;
use yii\bootstrap4\Carousel;
use yii\helpers\Html;

$this->title = 'DPW PPNI SUMATERA BARAT';
Yii::$app->params['showSubheader'] = false;
$this->context->layout = 'no-container/main';
?>

<style>
   /*  .carousel .carousel-item {
        height: 555px;
        text-align: center;
        background-color: #777;
    }
    .carousel-item img {
        position: absolute;
        object-fit: cover;
        top: 0;
        left: 0;
        min-height: 555px;
    } */
    
    .carousel-item:after {
        content:"";
        display:block;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
        background:rgba(0,0,0,0.5);
    }
</style>

<?php  
$slideshows = Slideshow::find()->all();
$items = [];
foreach ($slideshows as $slideshow) {
    $items[] = [
        'content' => Html::img(['/slideshow/download', 'id' => $slideshow->id], ['width' => '100%']),
        'caption' => '<h1 class="font-weight-boldest">'.$slideshow->title.'</h1><p>'.$slideshow->caption.'</p>',
        // 'captionOptions' => ['class' => ['d-none', 'd-md-block']]
        // 'options' => [],
    ];
}
?>

<?php if ($slideshows) { ?>
<?= Carousel::widget(['items' => $items]); ?>
<?php } else { ?>
<div class="subheader py-16 gradient" id="kt_subheader">
    <div class="container">
        <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
            <img src="<?= Yii::getAlias('@web') ?>/img/logo-ppni.png" class="h-200px mb-16">
            <h1 class="text-white lh-base fw-bold fs-2x fs-lg-3x">DPW PPNI SUMATERA BARAT</h1>
            <div class="fs-5 text-muted fw-bold">
                Dewan Pengurus Wilayah 
                <br>Persatuan Perawat Nasional Indonesia
                <br>Provinsi Sumatera Barat
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php 
    $visions  = Objective::find()->where(['type' => Objective::TYPE_VISION])->orderBy('sequence')->all();
    $missions = Objective::find()->where(['type' => Objective::TYPE_MISSION])->orderBy('sequence')->all();
?>

<div class="py-16 bg-white d-none">
    <div class="container">
        
        <h1 class="text-center mb-8">Visi & Misi PPNI</h1>

        <h4 class="text-danger font-weight-boldest">VISI PPNI</h4>
        <?php foreach($visions as $vision) { ?>
            <div class="card card-custom mb-4 rounded-lg bg-light-danger">
                <div class="card-body font-weight-bold">
                    <?= $vision->content ?>
                </div>
            </div>
        <?php } ?>

        <h4 class="text-danger font-weight-boldest mt-16">MISI PPNI</h4>
        <?php foreach($missions as $mission) { ?>
            <div class="card card-custom mb-4 rounded-lg bg-light">
                <div class="card-body font-weight-bold">
                    <?= $mission->content ?>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<div class="py-16">
    <div class="container">
        
        <h1 class="text-center mb-8">Berita Terbaru</h1>

        <?php $models = Blog::find()->orderBy('id DESC')->limit(3)->all(); ?>
        <?php foreach ($models as $model) { ?>
        <div class="card card-custom mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <?= Html::img(['/blog/download', 'id' => $model->id], ['class' => 'rounded border', 'width' => '100%']) ?>
                    </div>
                    <div class="col-9">
                        <div class="font-size-h5 font-weight-boldest mb-2"><?= $model->title ?></div>
                        <p><?= substr($model->content, 0, 240) ?> ...</p>
                        <?= Html::a('Selengkapnya', ['/blog/view', 'id' => $model->id], ['class' => 'btn btn-light-danger float-right']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    </div>
</div>
