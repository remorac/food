<?php

use yii\bootstrap4\Modal;

Modal::begin([
    'title'         => '',
    'headerOptions' => ['id' => 'modalHeader', 'style' => 'background:#eee'],
    'id'            => 'modal-universe',
    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style='text-align:center'><img src='".Yii::getAlias('@web/img/loader.gif')."'></div></div>";
Modal::end();

?>