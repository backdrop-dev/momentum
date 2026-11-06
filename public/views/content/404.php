<div id="content" class="<?php echo esc_attr( Momentum\content_class() ); ?>">
	<main id="main" class="app-main">
		<?php $error->setup(); ?>
		<article id="post-0" class="entry entry--404">
			<header class="entry__header">
				<h1 class="entry__title"><?php $error->displayTitle(); ?></h1>
			</header>
			<div class="entry__content">
				<?php $error->displayContent(); ?>
				<?php get_search_form(); ?>
			</div>
		</article>
		<?php $error->reset(); ?>
	</main>
	<?php Momentum\display_sidebar(); ?>
</div>
