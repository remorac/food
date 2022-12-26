<?php

use yii\helpers\Url;
?>

<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">

						<!--begin::Container-->
						<div class="container d-flex align-items-stretch justify-content-between">

							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">

									<!--begin::Header Nav-->
									<ul class="menu-nav">
										<li class="menu-item">
											<a href="<?= Url::to(['/']) ?>" class="brand-logo mr-16">
												<img alt="Logo" src="<?= Yii::getAlias('@web/img/logo-ppni.png') ?>" class="logo-default h-25px h-lg-30px mr-2 ml-4" style="margin-top: -8px" />
												<span class="font-size-h3 font-weight-boldest text-danger">PPNI Sumbar</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/']) ?>" class="menu-link">
												<span class="menu-text">Home</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/objective']) ?>" class="menu-link">
												<span class="menu-text">Visi & Misi</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/blog']) ?>" class="menu-link">
												<span class="menu-text">Berita</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/staff']) ?>" class="menu-link">
												<span class="menu-text">Struktur Kepengurusan</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/organization-subordinate']) ?>" class="menu-link">
												<span class="menu-text">DPD</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/organization-independent']) ?>" class="menu-link">
												<span class="menu-text">Ikatan/Himpunan</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/document']) ?>" class="menu-link">
												<span class="menu-text">Dokumen</span>
											</a>
										</li>
										<li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
											<a href="<?= Url::to(['/link']) ?>" class="menu-link">
												<span class="menu-text">Link</span>
											</a>
										</li>
									</ul>

									<!--end::Header Nav-->
								</div>

								<!--end::Header Menu-->
							</div>

							<!--end::Header Menu Wrapper-->

						</div>

						<!--end::Container-->
					</div>

					<!--end::Header-->