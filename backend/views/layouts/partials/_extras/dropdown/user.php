<?php 
	use \yii\helpers\Url;
?>

<div class="navi navi-spacer-x-0">
	<div class="navi-footer px-8 py-5">
		<a href="<?= Url::to(['/site/logout']) ?>" data-method="post" class="btn btn-light-primary font-weight-bold">Sign Out</a>
	</div>
</div>