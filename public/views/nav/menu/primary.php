<?php
/*
 * The primary menu. Chassis styles it by its structure (`.app-nav` > `.app-nav__menu` > `li` > `a`,
 * with nested lists for submenus), and its script opens it from the Menu button on phones.
 */
?>
<?php if ( has_nav_menu( $data->location ) ) : ?>
	<nav id="primary" class="app-nav" aria-label="<?php esc_attr_e( 'Primary', 'momentum' ); ?>">
		<button class="app-nav__toggle" type="button" aria-expanded="false" aria-controls="app-nav-menu"><?php esc_html_e( 'Menu', 'momentum' ); ?></button>
		<?php wp_nav_menu( [
			'theme_location' => $data->location,
			'container'      => false,
			'menu_id'        => 'app-nav-menu',
			'menu_class'     => 'app-nav__menu',
			'depth'          => 3,
		] ); ?>
	</nav>
<?php endif; ?>
