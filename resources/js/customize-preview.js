/**
 * Customize preview script: updates the preview without reloading it.
 *
 * Theme: Content -> Layout switches the content area between Chassis's
 * `app-content--sidebar-left` and `app-content--sidebar-right`, or hides the sidebar.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

wp.customize( 'theme_content_layout', ( setting ) => {
	setting.bind( ( layout ) => {
		const content = document.getElementById( 'content' );
		const sidebar = document.getElementById( 'aside' );

		if ( ! content ) {
			return;
		}

		// The sidebar is only in the page when it has widgets.
		const show = 'no-sidebar' !== layout && !! sidebar;

		content.classList.toggle( 'app-content--sidebar-left', show && 'left-sidebar' === layout );
		content.classList.toggle( 'app-content--sidebar-right', show && 'left-sidebar' !== layout );

		if ( sidebar ) {
			sidebar.hidden = ! show;
		}
	} );
} );
