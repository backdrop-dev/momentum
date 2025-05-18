<section id="content" class="site-content">
	<div id="global-layout" class="left-sidebar">
		<main id="main" class="content-area">
			<?php
				while ( have_posts() ) : the_post();
					Backdrop\View\display( 'entry/page' );
				endwhile;
			?>
		</main>
		<?php Backdrop\View\display( 'sidebar', 'primary', [ 'location' => 'primary' ] ); ?>
	</div>
</section>
