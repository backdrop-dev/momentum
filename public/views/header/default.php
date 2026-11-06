<!DOCTYPE html>
<html <?php Backdrop\Attr\display( 'html' ); ?>>
<head>
<?php wp_head(); ?>
</head>
<body <?php Backdrop\Attr\display( 'body' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'momentum' ); ?></a>

<?php
/*
 * The page skeleton comes from Chassis: `.app` wraps the page, and `.app-header`, `.app-nav`,
 * `.app-content` and `.app-footer` are its parts. Their look is set in `chassis.json`.
 */
?>
<div class="app">

	<header id="masthead" class="app-header">
		<div class="app-header__inner container">

			<div class="app-header__branding">
				<?php Backdrop\Site\display_title( [
					'tag'        => is_front_page() ? 'h1' : 'p',
					'class'      => 'app-header__title',
					'link_class' => 'app-header__title-anchor',
				] ); ?>
				<?php Backdrop\Site\display_description( [
					'tag'   => 'p',
					'class' => 'app-header__tagline',
				] ); ?>
			</div>

			<?php $engine->display( 'nav/menu', 'primary', [ 'location' => 'primary' ] ); ?>

		</div>
	</header>
