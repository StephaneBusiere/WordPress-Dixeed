<?php
/* enqueue script for parent theme stylesheeet */        
function childtheme_parent_styles() {
 
 // enqueue style
 wp_enqueue_style( 'parent', get_template_directory_uri().'/style.css' );                       
}
add_action( 'wp_enqueue_scripts', 'childtheme_parent_styles');

 function display_custom_shipping_methods() {
	?>
	<fieldset class="extra-fields">
		<legend><?php _e( 'Emergency', 'wc_ccf' ); ?></legend>

		<p>
			<label for="msk-urgent-order">
				<input type="checkbox" name="msk-urgent-order" id="msk-urgent-order" value="on" class="msk-custom-field" />
				<span><?php esc_html_e( 'Je suis pressé, envoie en urgence!', 'wc_ccf' ); ?></span>
			</label>
		</p>

		<p>
			<label for="msk-urgency-level">
				<span><?php esc_html_e( 'Quand voulez vous être livré?', 'wc_ccf' ); ?></span>
				<select name="msk-urgency-level" id="msk-urgency-level" class="msk-custom-field">
					<option value="_null"><?php esc_attr_e( '— Selectionner une option', 'wc_ccf' ); ?></option>
					<option value="next_hour"><?php esc_attr_e( 'Dans l\'heure prochaine ', 'wc_ccf' ); ?></option>
					<option value="next_6hours"><?php esc_attr_e( 'Dans les 6 prochaines heures', 'wc_ccf' ); ?></option>
					<option value="next_12hours"><?php esc_attr_e( 'Dans les 12 prochaines heures', 'wc_ccf' ); ?></option>
					<option value="tomorrow"><?php esc_attr_e( 'Demain', 'wc_ccf' ); ?></option>
				</select>
			</label>
		</p>
	</fieldset>

	<script>
		// When one of our custom field value changes, tell WC to update the checkout data (AJAX request to the back-end).
		jQuery(document).ready(function($) {
			$('form.checkout').on('change', '.msk-custom-field', function() {
				$('body').trigger('update_checkout');
			});
		});
	</script>
	<?php
}
add_action( 'woocommerce_checkout_billing', __NAMESPACE__ . '\\display_custom_shipping_methods', 10 );

function validate_all_checkout_fields() {
	$errors = [];

	if ( isset( $_POST['msk-urgent-order'] ) && $_POST['msk-urgent-order'] === 'on' ) {
		if ( ! isset( $_POST['msk-urgency-level'] ) || $_POST['msk-urgency-level'] === '_null' ) {
			$errors[] = __( 'Please tell us the <strong>level of emergency</strong>.', 'wc_ccf' );
		}

		elseif ( isset( $_POST['msk-urgency-level'] ) && ! in_array( $_POST['msk-urgency-level'], [ 'next_hour', 'next_6hours', 'next_12hours', 'tomorrow' ], true ) ) {
			$errors[] = __( 'This <strong>level of emergency</strong> is invalid.', 'wc_ccf' );
		}
	}

	/**
	 * If we have errors, 
	 */
	if ( ! empty( $errors ) ) {
		foreach ( $errors as $error ) {
			wc_add_notice( $error, 'error' );
		}
	}
}
add_action( 'woocommerce_checkout_process', __NAMESPACE__ . '\\validate_all_checkout_fields' );
function get_wc_posted_data() {
	$form_data = $_POST;

	if ( isset( $_POST['post_data'] ) ) {
		parse_str( $_POST['post_data'], $form_data );
	}

	return $form_data;
}

 function add_emergency_fee( $cart_object ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) || ! is_checkout() ) {
		return;
	}

	// Only trigger this logic once.
	if ( did_action( 'woocommerce_cart_calculate_fees' ) >= 2 ) {
		return;
	}	

	$form_data = get_wc_posted_data();

	// Do not calculate anything if we do not have our emergency field checked or no emergency level is provided.
	if ( ! isset( $form_data['msk-urgent-order'], $form_data['msk-urgency-level'] ) || $form_data['msk-urgent-order'] !== 'on' ) {
		return;
	}

	// Store a mutiplier/coefficient to calculate the emergency fee.
	$multipliers = [
		'next_hour'    => 2,
		'next_6hours'  => 1.5,
		'next_12hours' => 1.25,
		'tomorrow'     => 1.1,
	];

	if ( ! array_key_exists( $form_data['msk-urgency-level'], $multipliers ) ) {
		return;
	}

	// Add the extra fee to the user cart.
	WC()->cart->add_fee(
		__( 'Frais de port en urgence', 'wc_ccf' ),
		WC()->cart->subtotal * $multipliers[ $form_data['msk-urgency-level'] ],
		false
	);
}
add_action( 'woocommerce_cart_calculate_fees', __NAMESPACE__ . '\\add_emergency_fee' );

function add_custom_checkout_data_to_order_data_array( $data ) {
	$custom_keys = [
		'msk-urgent-order',
		'msk-urgency-level',
	];

	foreach ( $custom_keys as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$data[ $key ] = sanitize_text_field( $_POST[ $key ] );
		}
	}

	return $data;
}
add_filter( 'woocommerce_checkout_posted_data', __NAMESPACE__ . '\\add_custom_checkout_data_to_order_data_array', 10, 2 );

function save_custom_checkout_data_in_order_metadata( $order_id, $data ) {
	$custom_keys = [
		'msk-urgent-order',
		'msk-urgency-level',
	];

	$order = wc_get_order( $order_id );

	foreach ( $custom_keys as $key ) {
		if ( isset( $data[ $key ] ) ) {
			$order->add_meta_data( $key, $data[ $key ] );
		}
	}

	$order->save();
}
add_action( 'woocommerce_checkout_update_order_meta', __NAMESPACE__ . '\\save_custom_checkout_data_in_order_metadata', 10, 2 );