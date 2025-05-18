<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php Backdrop\Post\display_title(); ?>
		<div class="entry-metadata">
			<?php Backdrop\Post\display_author( [ 'before' => Momentum\sep() ] ); ?>
		 	<?php Backdrop\Post\display_date( [ 'before' => Momentum\sep() ] ); ?>
			<?php Backdrop\Post\display_comments_link( [ 'before' => Momentum\sep() ] ); ?>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<picture class="post-thumbnail">
			<?php the_post_thumbnail( Momentum\Tools\Mod::get( 'theme_content_feature_image' ) ); ?>
		</picture>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_excerpt(); ?>
</article>
