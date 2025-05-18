<?php
/**
 * General Settings View.
 *
 * Displays the general theme settings view (tab) on the settings page.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Settings\Admin\Views;

use Momentum\Settings\Options;
use function Backdrop\is_classicpress;

/**
 * General settings view class.
 *
 * @since  0.0.1
 * @access public
 */
class General extends View {

    /**
     * Holds the settings.
     *
     * @var array
     */
    private $settings;

	/**
	 * Returns the view name/ID.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {
		return 'general';
	}

	/**
	 * Returns the internationalized, human-readable view label.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function label() {

		return esc_html__( 'General', 'momentum' );
	}

	/**
	 * Called on the `admin_init` hook and should be used to register theme
	 * settings via the Settings API.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Get the current plugin settings w/o the defaults.
		$this->settings = get_option( 'momentum_settings' );

		// Register the setting.
		register_setting( 'momentum_settings', 'momentum_settings', [ $this, 'validateSettings' ] );

		// Register sections and fields.
		add_action( 'momentum/settings/admin/view/general/register', [ $this, 'registerDefaultSections' ] );
		add_action( 'momentum/settings/admin/view/general/register', [ $this, 'registerDefaultFields'   ] );
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
		do_action( 'momentum/settings/admin/view/general/register' );
	}

	/**
	 * Validates the settings.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validateSettings( $settings ) { // phpcs:ignore

		// Checkboxes.
		$settings['disable_emoji']    = ! empty( $settings['disable_emoji']    );
		$settings['disable_toolbar']  = ! empty( $settings['disable_toolbar']  );
		$settings['disable_wp_embed'] = ! empty( $settings['disable_wp_embed'] );

		// Integers.
		$settings['error_page'] = absint( $settings['error_page']           );

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * Registers default settings sections.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function registerDefaultSections() {

		$label = is_classicpress() ? __( 'Clean ClassicPress', 'momentum' ) : __( 'Clean WordPress', 'momentum' );

		$sections = [
			'reading' => [
				'label'    => __( 'Reading', 'momentum' ),
				'callback' => 'sectionReading'
			],
			'clean_cp' => [
				'label'    => $label,
				'callback' => 'sectionCleanCP'
			]
		];

		array_map( function( $name, $section ) {

			add_settings_section(
				$name,
				$section['label'],
				[ $this, $section['callback'] ],
				'momentum_settings'
			);

		}, array_keys( $sections ), $sections );
	}

	/**
	 * Registers default settings fields.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function registerDefaultFields() {

		$fields = [

			// Reading fields.
			'error_page' => [
				'label'    => __( '404 Page', 'momentum' ),
				'callback' => 'fieldErrorPage',
				'section'  => 'reading'
			],

			// Clean WP fields.
			'emoji' => [
				'label'    => __( 'Emoji', 'momentum' ),
				'callback' => 'fieldEmoji',
				'section'  => 'clean_cp',
			],
			'toolbar' => [
				'label'    => __( 'Toolbar', 'momentum' ),
				'callback' => 'fieldToolbar',
				'section'  => 'clean_cp'
			],
			'embeds' => [
				'label'    => __( 'Embeds', 'momentum' ),
				'callback' => 'fieldEmbeds',
				'section'  => 'clean_cp'
			]
		];

		array_map( function( $name, $field ) {

			add_settings_field(
				$name,
				$field['label'],
				[ $this, $field['callback'] ],
				'momentum_settings',
				$field['section']
			);

		}, array_keys( $fields ), $fields );
	}

	/**
	 * Displays the reading section.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function sectionReading() { ?>
		<p>
			<?php esc_html_e( 'Settings related to reading and display options for your site, including the 404 error page.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Displays the clean WP section.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function sectionCleanCP() { ?>

		<p>
			<?php esc_html_e( 'Clean up unnecessary items on the front end of your site for speed improvements.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Displays the 404 error page field.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function fieldErrorPage() {

		$dropdown = wp_dropdown_pages( [
			'name'              => 'momentum_settings[error_page]',
			'show_option_none'  => '-',
			'option_none_value' => 0,
			'selected'          => Options::get( 'error_page' ), // phpcs:ignore
			'post_status'       => [ 'private' ],
			'echo'              => false
		] ); ?>

		<p>
			<label>
				<?php if ( $dropdown ) : ?>

					<?php echo wp_kses( $dropdown, [
                    'select' => [
                        'name' => true,
                        'id' => true
                    ],
                    'option' => [
                        'value' => true,
                        'selected' => true
                    ]
                ] ); ?>

				<?php else : ?>

					<?php if ( current_user_can( 'publish_pages' ) ) : ?>

						<a href="<?php echo esc_url( add_query_arg( 'post_type', 'page', admin_url( 'post-new.php' ) ) ) ?>"><?php esc_html_e( 'Add New Page', 'momentum' ) ?></a>

					<?php endif ?>

				<?php endif ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'Select a page to display when users visit a 404 error on your site. Ensure the page is set to private so it does not appear on the front end.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Displays the emoji field.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function fieldEmoji() { ?>

		<p>
			<label>
				<input type="checkbox" name="momentum_settings[disable_emoji]" value="true" <?php checked( Options::get( 'disable_emoji' ) ) ?> />
				<?php esc_html_e( 'Disable Emoji Scripts', 'momentum' ) ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'All modern browsers support emoji natively. Disabling emoji scripts removes the JavaScript loaded on every page of your site for a small percentage of users on outdated browsers.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Displays the toolbar field.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function fieldToolbar() { ?>

		<p>
			<label>
				<input type="checkbox" name="momentum_settings[disable_toolbar]" value="true" <?php checked( Options::get( 'disable_toolbar' ) ) ?> />
				<?php esc_html_e( 'Disable Toolbar', 'momentum' ) ?>
			</label>
		</p>
		<p class="description">
			<?php esc_html_e( 'Disables the toolbar on the front end of the site, which loads additional JavaScript and CSS on every page load.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Displays the embeds field.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function fieldEmbeds() {
		$label = is_classicpress() ? __( 'Disable ClassicPress Embeds', 'momentum' ) : __( 'Disable WordPress Embeds', 'momentum' );
		?>

		<p>
			<label>
				<input type="checkbox" name="momentum_settings[disable_wp_embed]" value="true" <?php checked( Options::get( 'disable_wp_embed' ) ) ?> />
				<?php echo esc_html( $label ); ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'Removes the JavaScript that allows other sites to embed your posts.', 'momentum' ) ?>
		</p>

	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function template() { ?>
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Settings', 'momentum' ); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'momentum_settings' ); ?>
			<?php do_settings_sections( 'momentum_settings' ); ?>
			<?php submit_button( esc_attr__( 'Update Settings', 'momentum' ), 'primary' ); ?>
		</form>

	<?php }
}
