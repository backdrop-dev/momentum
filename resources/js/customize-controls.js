/**
 * Customize controls script: runs in the customizer's controls panel.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

/*
 * The Layout picker (Backdrop's `backdrop-radio-image` control).
 *
 * The control is a set of hidden radio buttons, each inside a label with a layout image.
 * It sets the value itself, rather than relying only on the customizer linking the radios
 * to the setting, and keeps the checked image in step when the setting changes elsewhere
 * (Undo, a changeset, another control).
 *
 * This runs as soon as the file loads, not on document ready: the customizer builds its
 * controls on document ready, and picks a control's constructor by type at that moment.
 */
wp.customize.controlConstructor[ 'backdrop-radio-image' ] = wp.customize.Control.extend( {
	ready() {
		const control = this;
		const inputs  = Array.from( control.container[ 0 ].querySelectorAll( 'input[type="radio"]' ) );

		if ( ! control.setting || ! inputs.length ) {
			return;
		}

		const select = ( input ) => {
			input.checked = true;

			if ( control.setting() !== input.value ) {
				control.setting.set( input.value );
			}
		};

		const sync = ( value ) => {
			inputs.forEach( ( input ) => {
				input.checked = input.value === value;
			} );
		};

		inputs.forEach( ( input ) => {
			// Keyboard: arrow keys move between the radios and fire `change`.
			input.addEventListener( 'change', () => {
				if ( input.checked ) {
					select( input );
				}
			} );

			// Mouse and touch: a click anywhere on the image picks that layout.
			const label = input.closest( 'label' );

			if ( label ) {
				label.addEventListener( 'click', () => select( input ) );
			}
		} );

		control.setting.bind( sync );
		sync( control.setting() );
	},
} );
