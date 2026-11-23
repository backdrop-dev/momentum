<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php Backdrop\Theme\Entry\display_title( [ 'class' => 'entry__title' ] ); ?>
		<div class="entry__metadata">
			<?php Backdrop\Theme\Entry\display_date(); ?>
			<?php Backdrop\Theme\Entry\display_author( [ 'before' => Momentum\sep() ] ); ?>
			<?php Backdrop\Theme\Entry\display_comments_link( [ 'before' => Momentum\sep() ] ); ?>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="entry__thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( Momentum\Tools\Mod::get( 'theme_content_feature_image', Momentum\Tools\Mod::fallback( 'featured_image_size' ) ) ); ?>
		</a>
	<?php endif; ?>
	<div class="entry__content">
		<?php the_excerpt(); ?>
	</div>
</article>
