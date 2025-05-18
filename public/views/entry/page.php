<article id="post-<?php the_ID(); ?>" <?php post_class( 'default' ); ?>>
	<header class="entry-header">
		<?php Backdrop\Post\display_title(); ?>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
</article>
