	<footer id="colophon" class="app-footer">
		<div class="app-footer__inner container">
			<?php Backdrop\View\display( 'sidebar', 'footer', [ 'location' => 'footer' ] ); ?>
			<?php Backdrop\View\display( 'nav/menu', 'social', [ 'location' => 'social' ] ); ?>
			<?php Momentum\Template\Footer::displayCredit(); ?>
		</div>
	</footer>

</div><!-- .app -->

<?php wp_footer(); ?>
</body>
</html>
