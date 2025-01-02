<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title><?= isset($pageTitle) ? $pageTitle : 'New Page Title'; ?></title>

	<!-- Site favicon -->
	<link
		rel="apple-touch-icon"
		sizes="180x180"
		href="/backend/vendors/images/apple-touch-icon.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="32x32"
		href="/backend/vendors/images/favicon-32x32.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="16x16"
		href="/backend/vendors/images/favicon-16x16.png" />

	<!-- Mobile Specific Metas -->
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link
		href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
	<link
		rel="stylesheet"
		type="text/css"
		href="/backend/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />
	<link rel="stylesheet" href="/extra-assets/ijoboCropTool/ijaboCropTool.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picocrop@1.0.0/dist/picocrop.min.css">

	<?= $this->renderSection('stylesheet') ?>
</head>

<body>
	<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<h1>WISATA TEGAL </h1>
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div> -->

	<?php include('inc/header.php') ?>

	<?php include('inc/right-sidebar.php') ?>

	<?php include('inc/left-side-bar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<?php $this->renderSection('content') ?>
			</div>
			<?php include('inc/footer.php') ?>
		</div>
	</div>

	<!-- js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="/backend/vendors/scripts/core.js"></script>
	<script src="/backend/vendors/scripts/script.min.js"></script>
	<script src="/backend/vendors/scripts/process.js"></script>
	<script src="/backend/vendors/scripts/layout-settings.js"></script>
	<script src="/extra-assets/ijoboCropTool/ijaboCropTool.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/picocrop@1.0.0/dist/picocrop.min.js"></script>


	<?= $this->renderSection('javascript') ?>
</body>

</html>