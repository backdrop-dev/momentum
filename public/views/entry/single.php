
<article id="post-<?php the_ID(); ?>" <?php post_class( 'default' ); ?>>
	<header class="entry-header">
		<?php Backdrop\Post\display_title(); ?>
		<div class="entry-metadata">
			<?php Backdrop\Post\display_author(); ?>
			<?php Backdrop\Post\display_date(); ?>
			<?php Backdrop\Post\display_comments_link(); ?>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<picture class="post-thumbnail">
			<?php the_post_thumbnail( Generosity\Tools\Mod::get( 'theme_content_feature_image' ) ); ?>
		</picture>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
	</div>
</article>
