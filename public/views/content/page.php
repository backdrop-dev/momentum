<div id="content" class="<?php echo esc_attr( Momentum\content_class() ); ?>">
	<main id="main" class="app-main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php Backdrop\View\display( 'entry', 'page' ); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
	</main>
	<?php Momentum\display_sidebar(); ?>
</div>
