<!DOCTYPE html>
<html <?php Backdrop\Attr\display( 'html' ); ?>>
<head>
<?php wp_head(); ?>
</head>
<body <?php Backdrop\Attr\display( 'body' ); ?>>
<?php wp_body_open(); ?>
<div id="container" class="site-container">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'momentum' ); ?></a>
	<header id="masthead" class="site-header">
		<div class="site-header__branding">
			<?php Backdrop\Site\display_title(); ?>
			<?php Backdrop\Site\display_description(); ?>
		</div>
		<?php $engine->display( 'nav/menu', 'primary', [ 'location' => 'primary' ] ); ?>
	</header>
