<?php

class WOOCCM_Fields_Conditional {

	protected static $_instance;

	public function __construct() {
		// Add field attributes
		add_filter( 'wooccm_checkout_field_filter', array( $this, 'add_field_attributes' ) );
		add_action( 'wooccm_billing_fields', array( $this, 'remove_required' ) );
		add_action( 'wooccm_shipping_fields', array( $this, 'remove_required' ) );
		add_action( 'wooccm_additional_fields', array( $this, 'remove_required' ) );
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function remove_required( $fields ) {
		foreach ( $fields as $field_id => $field ) {

			/**
			 * Continue if it's not a conditional field
			 */
			if ( empty( $field['conditional'] ) ) {
				continue;
			}
			/**
			 * Continue if it doesn't have the conditional parent key
			 */
			if ( empty( $field['conditional_parent_key'] ) ) {
				continue;
			}
			/**
			 * Continue if it's parent of self
			 */
			if ( $field['conditional_parent_key'] == $field['key'] ) {
				continue;
			}
			/**
			 * Continue if parent dosen't exists
			 */
			if ( empty( $fields[ $field['conditional_parent_key'] ] ) ) {
				continue;
			}

			$action = $this->get_checkout_action();

			switch ( $action ) {
				case 'save':
					$is_valid_conditional_field = $this->is_valid_conditional_field( $_POST, $field );
					if ( ! $is_valid_conditional_field ) {
						$fields[ $field['key'] ]['required'] = false;
					}
					break;
				case 'update':
					$post_data = array();
					parse_str( $_REQUEST['post_data'], $post_data );
					$is_valid_conditional_field = $this->is_valid_conditional_field( $post_data, $field );
					if ( ! $is_valid_conditional_field ) {
						$fields[ $field['key'] ]['required'] = false;
					}
					break;
			}
		}

		return $fields;
	}

	public function is_valid_conditional_field( $post_data, $field ) {
		/**
		 * Don't remove field if parent dosen't exists in the current form posts
		 */

		if ( ! isset( $post_data[ $field['conditional_parent_key'] ] ) ) {
			return false;
		}
		/**
		 * Don't remove field if conditional parent value is undefined
		 */
		if ( ! isset( $field['conditional_parent_value'] ) ) {
			return false;
		}

		$posted_conditional_parent_value = (array) $post_data[ $field['conditional_parent_key'] ];
		$conditional_parent_value        = (array) $field['conditional_parent_value'];
		/**
		 * Don't remove field if conditional parent value is valid
		 */
		if ( array_intersect( $conditional_parent_value, $posted_conditional_parent_value ) ) {
			return true;
		}

		return false;
	}

	public function get_checkout_action() {
		if ( isset( $_REQUEST['woocommerce-process-checkout-nonce'] ) ) {
			return 'save';
		} elseif ( isset( $_REQUEST['post_data'] ) && isset( $_REQUEST['wc-ajax'] ) && $_REQUEST['wc-ajax'] == 'update_order_review' ) {
			return 'update';
		}
	}

	public function add_field_attributes( $field ) {
		if ( ! empty( $field['conditional'] ) && ! empty( $field['conditional_parent_key'] ) && isset( $field['conditional_parent_value'] ) && ( $field['conditional_parent_key'] != $field['name'] ) ) {
			$field['class'][]                                      = 'wooccm-conditional-child';
			$field['custom_attributes']['data-conditional-parent'] = $field['conditional_parent_key'];
			$field['custom_attributes']['data-conditional-parent-value'] = $field['conditional_parent_value'];
		}
		return $field;
	}
}

WOOCCM_Fields_Conditional::instance();
