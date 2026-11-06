<?php if ( is_active_sidebar( $data->location ) ) : ?>
	<aside class="app-footer__widgets grid grid--3" aria-label="<?php esc_attr_e( 'Footer', 'momentum' ); ?>">
		<?php dynamic_sidebar( $data->location ); ?>
	</aside>
<?php endif; ?>
