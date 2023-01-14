<?php
	$containerClass = 'container-fluid d-flex align-items-stretch justify-content-between';
	if (!Yii::$app->user->isGuest && Yii::$app->user->identity->unit_id) $containerClass = 'container d-flex align-items-stretch justify-content-between';
?>

<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">

						<!--begin::Container-->
						<div class="<?= $containerClass ?>">

							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">

									<?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->unit_id) { ?>
									<!--begin::Header Nav-->
									<ul class="menu-nav">
										<li class="menu-item">
											<a href="#" class="brand-logo">
												<span class="font-size-h4 font-weight-bold text-dark"><?= Yii::$app->name ?></span>
											</a>
										</li>
									</ul>
									<?php } ?>

									<!--end::Header Nav-->
								</div>

								<!--end::Header Menu-->
							</div>

							<!--end::Header Menu Wrapper-->

							<!--begin::Topbar-->
							<div class="topbar">

								<!--begin::Notifications-->
								<div class="dropdown">

									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<form>

											<!--[html-partial:include:{"file":"partials/_extras/dropdown/notifications.html"}]/-->
											<?= '' // $this->render('_extras/dropdown/notifications.php') ?>
										</form>
									</div>

									<!--end::Dropdown-->
								</div>

								<!--end::Notifications-->

								<!--begin::User-->
								<div class="dropdown">

									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
										<div class="btn btn-icon btn-dropdown w-auto btn-clean d-flex align-items-center btn-lg px-2">
											<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
											<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?= Yii::$app->user->identity->name ?></span>
											<span class="symbol symbol-35 symbol-light-success">
												<span class="symbol-label font-size-h5 font-weight-bold">S</span>
											</span>
										</div>
									</div>

									<!--end::Toggle-->

									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">

										<!--[html-partial:include:{"file":"partials/_extras/dropdown/user.html"}]/-->
										<?= $this->render('_extras/dropdown/user.php') ?>
									</div>

									<!--end::Dropdown-->
								</div>

								<!--end::User-->
							</div>

							<!--end::Topbar-->
						</div>

						<!--end::Container-->
					</div>

					<!--end::Header-->