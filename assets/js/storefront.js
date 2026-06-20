/**
 * Preorder — storefront micro-interaction.
 *
 * The reservation stub "validates" with a single punch: once when it first
 * appears, and again when the shopper presses the pre-order button (the moment
 * of commitment). Presentation only — it never touches cart behaviour, which
 * is handled server-side by PreorderService.
 *
 * Vanilla JS, no dependencies. Respects prefers-reduced-motion (the CSS keyframe
 * is suppressed there; we still toggle the class so the dot reaches its rest
 * state).
 */
( function ( $ ) {
	'use strict';

	function validate( stub ) {
		if ( ! stub ) {
			return;
		}
		stub.classList.remove( 'is-validated' );
		void stub.offsetWidth;
		stub.classList.add( 'is-validated' );
	}

	function setStubVisible( stub, visible ) {
		if ( ! stub ) {
			return;
		}
		stub.classList.toggle( 'preorder-stub--hidden', ! visible );
		if ( visible ) {
			validate( stub );
		}
	}

	function defaultButtonText( button ) {
		if ( ! button ) {
			return '';
		}
		return button.getAttribute( 'data-preorder-default-text' ) || button.textContent || '';
	}

	function setButtonText( button, text ) {
		if ( ! button || ! text ) {
			return;
		}
		button.textContent = text;
	}

	function initVariableProduct( stub, form ) {
		var button = form.querySelector( '.single_add_to_cart_button' );

		if ( button && ! button.getAttribute( 'data-preorder-default-text' ) ) {
			button.setAttribute( 'data-preorder-default-text', button.textContent || '' );
		}

		$( form ).on( 'show_variation', function ( event, variation ) {
			var isPreorder = variation && variation.preorder_is_preorder;
			setStubVisible( stub, !! isPreorder );
			if ( isPreorder && variation.preorder_add_to_cart_text ) {
				setButtonText( button, variation.preorder_add_to_cart_text );
			} else {
				setButtonText( button, defaultButtonText( button ) );
			}
		} );

		$( form ).on( 'hide_variation', function () {
			setStubVisible( stub, false );
			setButtonText( button, defaultButtonText( button ) );
		} );
	}

	function init() {
		var stub = document.querySelector( '.preorder-stub' );
		if ( ! stub ) {
			return;
		}

		if ( ! stub.hasAttribute( 'data-preorder-variable' ) ) {
			validate( stub );
		}

		var form = stub.closest( 'form.cart' ) || document.querySelector( 'form.cart' );
		if ( form ) {
			if ( stub.hasAttribute( 'data-preorder-variable' ) ) {
				initVariableProduct( stub, form );
			}

			form.addEventListener( 'submit', function () {
				if ( ! stub.classList.contains( 'preorder-stub--hidden' ) ) {
					validate( stub );
				}
			} );
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}( window.jQuery ) );
