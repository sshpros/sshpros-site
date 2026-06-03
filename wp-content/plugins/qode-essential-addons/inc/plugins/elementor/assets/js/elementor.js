(function ( $ ) {
	'use strict';

	$( window ).on(
		'elementor/frontend/init',
		function () {
			qodefElementor.init();
		}
	);

	var qodefElementor = {
		init: function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				for ( var key in qodefEssentialCore.shortcodes ) {
					for ( var keyChild in qodefEssentialCore.shortcodes[key] ) {
						qodefElementor.reInitShortcode(
							key,
							keyChild
						);
					}
				}
			}
		},
		reInitShortcode: function ( key, keyChild ) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/' + key + '.default',
				function ( e ) {
					// Check if object doesn't exist and print the module where is the error.
					if ( typeof qodefEssentialCore.shortcodes[key][keyChild] === 'undefined' ) {
						console.log( keyChild );
					} else if ( typeof qodefEssentialCore.shortcodes[key][keyChild].createSlider === 'function' ) {
						var $sliders = e.find( '.qodef-swiper-container' );
						if ( $sliders.length ) {
							$sliders.each(
								function () {
									qodefEssentialCore.shortcodes[key][keyChild].createSlider( $( this ) );
								}
							);
						}
					} else if ( typeof qodefEssentialCore.shortcodes[key][keyChild].initItem === 'function' && e.find( '.qodef-shortcode' ).length ) {
						qodefEssentialCore.shortcodes[key][keyChild].initItem( e.find( '.qodef-shortcode' ) );
					} else {
						qodefEssentialCore.shortcodes[key][keyChild].init();
					}
				}
			);
		},
	};

})( jQuery );
