<?php if ( is_active_sidebar( $data->location ) ) : ?>
	<aside id="aside" class="app-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'momentum' ); ?>"<?php echo empty( $data->hidden ) ? '' : ' hidden'; ?>>
		<?php dynamic_sidebar( $data->location ); ?>
	</aside>
<?php endif; ?>
