<section id="content" class="site-content">
	<div id="global-layout" <?php Backdrop\Attr\display( Momentum\Tools\Mod::get( 'theme_content_layout' ) ); ?>>
		<main id="main" class="content-area">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					Backdrop\View\display( 'entry' );
				endwhile;
				the_posts_pagination();
			else :
				Backdrop\View\display( 'entry/none' );
			endif;
			?>
		</main>
		<?php Backdrop\View\display( 'sidebar', 'primary', [ 'location' => 'primary' ] ); ?>
	</div>
</section>
