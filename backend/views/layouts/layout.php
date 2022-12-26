<?php

use common\widgets\Alert;
?>

<!--begin::Main-->

		<!--[html-partial:include:{"file":"partials/_header-mobile.html"}]/-->
		<?= $this->render('partials/_header-mobile.php') ?>
		<div class="d-flex flex-column flex-root">

			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">

				<!--[html-partial:include:{"file":"partials/_aside.html"}]/-->
				<?= $this->render('partials/_aside.php') ?>

				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

					<!--[html-partial:include:{"file":"partials/_header.html"}]/-->
					<?= $this->render('partials/_header.php') ?>

					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

						<!--[html-partial:include:{"file":"partials/_subheader/subheader-v1.html"}]/-->
						<?= $this->render('partials/_subheader/subheader-v1.php') ?>

						<!--Content area here-->
						<div class="d-flex flex-column-fluid">
							<div class="container-fluid">
								<?= Alert::widget() ?>
								<?= $content ?>
							</div>
						</div>

					</div>
					<!--end::Content-->

					<!--[html-partial:include:{"file":"partials/_footer.html"}]/-->
					<?= $this->render('partials/_footer.php') ?>
				</div>

				<!--end::Wrapper-->
			</div>

			<!--end::Page-->
		</div>

		<!--end::Main-->