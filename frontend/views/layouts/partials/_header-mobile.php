<?php

use yii\helpers\Url;
?>

<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">

			<!--begin::Logo-->
			<a href="<?= Url::to(['/']) ?>">
				<img alt="Logo" src="<?= Yii::getAlias('@web/img/logo-ppni.png') ?>" height="35px" class="mr-4"/>
				<span class="font-size-h4 font-weight-bold text-light-danger">PPNI Sumbar</span>
			</a>

			<!--end::Logo-->

			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">

				<!--begin::Header Menu Mobile Toggle-->
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<!--end::Header Menu Mobile Toggle-->
				
			</div>

			<!--end::Toolbar-->
		</div>

		<!--end::Header Mobile-->