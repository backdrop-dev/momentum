<div id="content" class="<?php echo esc_attr( Momentum\content_class() ); ?>">
	<main id="main" class="app-main">
		<?php if ( have_posts() ) : ?>
			<?php if ( is_archive() || is_search() ) : ?>
				<header class="section-header">
					<h1 class="section-header__title">
						<?php if ( is_search() ) : ?>
							<?php
							// Translators: %s is the search query.
							printf( esc_html__( 'Search results for: %s', 'momentum' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
							?>
						<?php else : ?>
							<?php echo wp_kses_post( get_the_archive_title() ); ?>
						<?php endif; ?>
					</h1>
					<?php the_archive_description( '<div class="section-header__description">', '</div>' ); ?>
				</header>
			<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php Backdrop\View\display( 'entry' ); ?>
			<?php endwhile; ?>
			<?php Backdrop\View\display( 'nav/pagination', 'posts' ); ?>
		<?php else : ?>
			<?php Backdrop\View\display( 'entry', 'none' ); ?>
		<?php endif; ?>
	</main>
	<?php Momentum\display_sidebar(); ?>
</div>
