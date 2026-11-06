<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php Backdrop\Post\display_title( [ 'class' => 'entry__title' ] ); ?>
		<div class="entry__metadata">
			<?php Backdrop\Post\display_date(); ?>
			<?php Backdrop\Post\display_author( [ 'before' => Momentum\sep() ] ); ?>
			<?php Backdrop\Post\display_comments_link( [ 'before' => Momentum\sep() ] ); ?>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry__thumbnail">
			<?php the_post_thumbnail( Momentum\Tools\Mod::get( 'theme_content_feature_image', Momentum\Tools\Mod::fallback( 'featured_image_size' ) ) ); ?>
		</figure>
	<?php endif; ?>
	<div class="entry__content">
		<?php the_content(); ?>
		<?php Backdrop\View\display( 'nav/pagination', 'post' ); ?>
	</div>
	<footer class="entry__terms">
		<?php Backdrop\Post\display_terms( [
			// Translators: %s is the category list.
			'text'     => __( 'Posted in %s', 'momentum' ),
			'taxonomy' => 'category',
		] ); ?>
		<?php Backdrop\Post\display_terms( [
			// Translators: %s is the tag list.
			'text'     => __( 'Tagged %s', 'momentum' ),
			'taxonomy' => 'post_tag',
			'before'   => Momentum\sep(),
		] ); ?>
	</footer>
</article>
<?php the_post_navigation(); ?>
