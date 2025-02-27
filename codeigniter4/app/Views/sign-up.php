<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
    <head>
    <title>Sign-Up</title>
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico'); ?>" /> <!-- Use base_url() -->
    
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    
    <!--begin::Page Vendor Stylesheets (used by this page)-->
    <link href="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css'); ?>" rel="stylesheet" type="text/css" /> <!-- Use base_url() -->
    <!--end::Page Vendor Stylesheets-->
    
    <!--begin::Global Stylesheets Bundle (used by all pages)-->
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" /> <!-- Use base_url() -->
    <link href="<?= base_url('assets/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css" /> <!-- Use base_url() -->
	<script src="<?= base_url('js/disable_button.js'); ?>"></script>
	<script src="<?= base_url('js/language.js'); ?>" defer></script> <!-- Include the global.js file -->
    <!--end::Global Stylesheets Bundle-->
  </head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body" data-page="sign-up">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-up -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" >
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="#">
						<img alt="Logo" src="<?= base_url("logos/The Clock_Black.png"); ?>" class="h-110px logo" />
						</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->

							<?php if (isset($validation)): ?>
    						<div class="alert alert-danger">
       						 <ul>
            				<?php foreach ($validation->getErrors() as $error): ?>
              			  <li><?= esc($error) ?></li>
            			<?php endforeach; ?>
        				</ul>
    					</div>
						<?php endif; ?>

	
						<form class="form w-100" action="<?= isset($user) ? base_url('metronic/users/saveuser/') . $user['id'] : base_url('metronic/users/saveuser') ?>" novalidate="novalidate" id="kt_sign_up_form" method="post">
							<!--begin::Heading-->
							<div class="mb-10 text-center">
								<!--begin::Title-->
								<h1 class="text-dark mb-3"><?= isset($user) ? "Edit account": "Create account" ?></h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Already have an account?
								<a href="<?= base_url('metronic/login'); ?>" class="link-primary fw-bolder">Sign in here</a></div>
								<!--end::Link-->
							</div>
							<!--end::Heading-->
							<!--begin::Action-->

							<!--end::Action-->
							<!--begin::Separator-->
							<div class="d-flex align-items-center mb-10">
								<div class="border-bottom border-gray-300 mw-50 w-100"></div>
	
								<div class="border-bottom border-gray-300 mw-50 w-100"></div>
							</div>
							<!--end::Separator-->
							<!--begin::Input group-->
							<div class="row fv-row mb-7">

								
									<label class="form-label fw-bolder text-dark fs-6" for="username">User name</label>
									<input id="username" class="form-control form-control-lg form-control-solid" type="text" placeholder="F.e: 'John doe'" name="name" autocomplete="off" value="<?= isset($user) ? $user['nombre'] : "" ?>"/>
								


							</div>
							<!--end::Input group-->
							<!--begin::Input group for Role-->
<div class="fv-row mb-7">
    <label class="form-label fw-bolder text-dark fs-6" for="role">Role</label>
    <select id="role" class="form-control form-control-lg form-control-solid" name="role">
        <option value="">Select Role</option>
        <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $role): ?>
                <option value="<?= esc($role['Name']) ?>" <?= (isset($user) && $user['rol'] == $role['id']) ? 'selected' : '' ?>>
                    <?= esc($role['Name']) ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
<!--end::Input group for Role-->
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<label class="form-label fw-bolder text-dark fs-6" for="year">Year</label>
								<input id="year" class="form-control form-control-lg form-control-solid" type="text" placeholder="F.e: '1987'" name="year" autocomplete="off" value="<?= isset($user) ? $user['epoca'] : "" ?>"/>
							</div>
							<!--end::Input group-->
							<input type="hidden" name="language" id="language" value="" />
							<!--begin::Input group-->
							<div class="mb-10 fv-row" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6">Password</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-lg form-control-solid" type="password" placeholder="********" name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
									<!--begin::Meter-->
									<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
									</div>
									<!--end::Meter-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Hint-->
								<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
								<!--end::Hint-->
							</div>
							<!--end::Input group=-->
							<div class="mb-3">

							<!--begin::Input group-->
							<div class="fv-row mb-5">
								<label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
								<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->

							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<button type="submit" id="" class="btn btn-lg btn-primary">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>

							</div>
							<!--end::Actions-->

						</form>
						<!--end::Form-->
						<br>
							<div class="language-switch">
    							<button id="switch-to-en" type="button" class="btn btn-secondary">English</button>
    							<button id="switch-to-es" type="button" class="btn btn-secondary">Español</button>
							</div>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-up-->
		</div>
		<!--end::Main-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="<?= base_url('assets/plugins/global/plugins.bundle.js'); ?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js'); ?>"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="<?= base_url('assets/js/custom/authentication/sign-up/general.js'); ?>"></script>

		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>