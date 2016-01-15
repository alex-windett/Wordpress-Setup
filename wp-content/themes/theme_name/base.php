<?php
use PD\ThemeFramework\Wrapper;
use PD\ThemeFramework\Setup;

$template = Wrapper\hold_template();
?>
<!doctype html>
	<!--[if lt IE 9]><html class="lt-ie9 no-js" <?php language_attributes() ?>><![endif]-->
	<!--[if IE 9]><html class="ie9 no-js" <?php language_attributes() ?>><![endif]-->
	<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes() ?>><!--<![endif]-->
	<head>

		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<?php wp_head() ?>

		<!-- Text Rendering on some Android Devices -->
		<?php
		if (!empty($_SERVER['HTTP_USER_AGENT'])) {
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if(stripos($ua,'android') !== false):
			?>
			<style>
				h1,h2,h3,h4,h5,h6,p {text-rendering:auto;}
			</style>
		<?php endif;
		} ?>

	</head>
	<body <?php body_class() ?>>

		<?= $template ?>
		<?php wp_footer() ?>

	</body>
</html>
