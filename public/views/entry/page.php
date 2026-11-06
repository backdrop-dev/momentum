<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php Backdrop\Post\display_title( [ 'class' => 'entry__title' ] ); ?>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry__thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</figure>
	<?php endif; ?>
	<div class="entry__content">
		<?php the_content(); ?>
		<?php Backdrop\View\display( 'nav/pagination', 'post' ); ?>
	</div>
</article>
