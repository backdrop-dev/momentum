<?php
/**
 * Plugin class.
 *
 * Creates a plugin object.
 *
 * @package   Momentum
 */

namespace Momentum\Settings\PluginManager;

class Plugin {

    protected $name;
    protected $label;
    protected $author;
    protected $download_url = '';
    protected $description = '';

    /**
     * Constructor to initialize the plugin.
     *
     * @param string $name The plugin slug or path.
     * @param array  $options Optional options from the configuration.
     */
    public function __construct( $name, $options = [] ) {
        $this->name         = $name;
        $this->label        = $options['label'] ?? '';
        $this->description  = $options['description'] ?? '';
        $this->download_url = $options['download_url'] ?? '';
        $this->author       = $options['author'] ?? '';
    }

    /**
     * Plugin Data Accessors
     */
    public function name() {
        return $this->name;
    }

    public function label() {
        return $this->label;
    }

    public function downloadUrl() {
        return $this->download_url;
    }

    public function description() {
        return $this->description;
    }

    public function author() {
        return $this->author;
    }

    /**
     * Renders the plugin card HTML.
     */
    public function displayCard() {
        if ( $this->name === 'classicpress-directory-integration/classicpress-directory-integration.php' ) {
            return;
        }
        ?>
        <div class="plugin-card" aria-describedby="<?php echo esc_attr( sprintf( '%1$s-action %1$s-name', $this->name() ) ) ?>" data-slug="<?php echo esc_attr( $this->name() ) ?>">

            <div class="plugin-title" style="padding: 0 1rem">
                <h2 class="plugin-name" id="<?php echo esc_attr( sprintf( '%s-name', $this->name() ) ) ?>" style="margin-bottom: 0.25rem;">
                    <?php echo esc_html( $this->label() ) ?>
                </h2>
                <?php echo esc_html( wp_strip_all_tags( $this->author() ) ); ?>
            </div>

            <div class="plugin-description" style="padding: 1rem; margin-bottom: 1rem;">
                <p><?php echo esc_html( wp_strip_all_tags( $this->description() ) ); ?></p>
            </div>

            <?php if ( $this->download_url !== '' ): ?>
                <div class="plugin-download" style="padding: 1rem;">
                    <a class="button button-primary" href="<?php echo esc_url( $this->download_url ); ?>">Download Plugin</a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
