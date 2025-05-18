<?php
/**
 * Plugins Settings View.
 *
 * Displays the plugins view (tab) on the settings page.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Settings\Admin\Views;

use Momentum\Settings\PluginManager\Plugins as PluginCollection;

/**
 * Plugins settings view class.
 *
 * @since  0.0.1
 * @access public
 */
class Plugins extends View {

	/**
	 * Collection of plugins.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    PluginCollection
	 */
	protected $plugins;

	/**
	 * Returns the view name/ID.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {
		return 'plugins';
	}

	/**
	 * Returns the internationalized, human-readable view label.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function label() {
		return __( 'Plugins', 'momentum' );
	}

	/**
	 * Called on the `admin_init` hook and should be used to register plugin
	 * settings via the Settings API.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Register plugins.
		add_action( 'momentum/settings/admin/view/plugins/register', [ $this, 'registerDefaultPlugins' ] );
	}

	/**
	 * Called on the `load-{$page}` hook when the view is booted. Use this
	 * to add any actions or filters needed.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {
		$this->plugins = new PluginCollection();

		do_action( 'momentum/settings/admin/view/plugins/register', $this->plugins );
	}

	/**
	 * Registers default settings sections.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  PluginCollection  $plugins
	 * @return void
	 */
	public function registerDefaultPlugins( PluginCollection $plugins ) {

		$contents = file_get_contents( get_parent_theme_file_path( 'config/plugins.json' ) );
		$config   = json_decode( $contents, true );

		// Add all active plugins to the collection.
		$active_plugins = get_option( 'active_plugins', [] );
		foreach ( $active_plugins as $plugin ) {
			$plugins->add( $plugin, [] );
		}

		// Remove any active plugins from the config.
		foreach ( $active_plugins as $plugin ) {
			if ( isset( $config[ $plugin ] ) ) {
				unset( $config[ $plugin ] );
			}
		}

		// Add all plugins from the config.
		foreach ( $config as $slug => $options ) {
			$plugins->add( $slug, $options );
		}
	}

	/**
	 * Renders the settings page.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function template() { ?>

		<div class="plugin-browser">
			<div class="plugins wp-clearfix">
				<?php foreach ( $this->plugins as $plugin ) : ?>
					<?php $plugin->displayCard() ?>
				<?php endforeach ?>
			</div>
		</div>
	<?php }
}
