<?php
/**
 * This file contains the shortcodes for displaying the testimonial in a content area.
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/**
 * Display testimonials shortcode
 *
 * Format for setting up shortcode.
 * useage : [katb_testimonial group="all" number="all" by="date" id="" rotate="no" layout="0" schema="default"]
 * group : "all" or "group" where group is the identifier in the testimonial
 * by : "date" or "order" or "random"
 * number : "all" or input the number you want to display
 * id : "" or ids of testimonials
 * rotate : "no" do not rotate, "yes" rotate testimonials
 * layout : 0-default,1-no format top meta, 2-no format bottom meta, 3-no format side meta,
 *          4-format top meta, 5-format bottom meta, 6-format side meta, 7-no format mosaic, 8-format mosaic
 * schema : default-whatever is set up in the General Options Panel, yes-override to yes, no-override to no
 *
 * @param array $atts contains the shortcode parameters.
 * @uses katb_get_options() function to get plugin options found in katb_functions.php
 * @uses katb_offset_setup() for pagination found in katb_functions.php
 * @uses katb_setup_pagination for pagination  found in katb_functions.php
 * @uses katb_content_display sets up the testimonial display found in katb_functions.php
 * @uses katb_get_display_pagination_string displays pagination  found in katb_functions.php
 *
 * @return string $katb_html containging the html of the testimonial display request
 * ------------------------------------------------------------------------- */
function katb_list_testimonials( $atts ) {
	// Get options.
	global $katb_options;
	// Initialize main testimonial arrays.
	$katb_tdata      = array();
	$use_schema      = $katb_options['katb_use_schema'];
	$display_reviews = $katb_options['katb_schema_display_reviews'];
	// Validate/whitelist group.
	if ( isset( $atts['group'] ) ) {
		$group = sanitize_text_field( $atts['group'] );
		if ( '' === $group || 'All' === $group ) {
			$group = 'all';
		}
	} else {
		$group = 'all';
	}
	// Validate/whitelist Number.
	if ( isset( $atts['number'] ) ) {
		$number = strtolower( sanitize_text_field( $atts['number'] ) );
		if ( '' === $number || 'All' === $number ) {
			$number = 'all';
		} elseif ( 'all' !== $number ) {
			if ( 1 > intval( $number ) ) {
				$number = 1;
			} else {
				$number = intval( $number );
			}
		}
	} else {
		$number = 'all';
	}
	// White list by.
	if ( isset( $atts['by'] ) ) {
		$by = strtolower( sanitize_text_field( $atts['by'] ) );
		if ( 'date' !== $by && 'order' !== $by ) {
			$by = 'random';
		}
	} else {
		$by = 'random';
	}
	// Validate ids.
	if ( isset( $atts['id'] ) ) {
		$id = sanitize_text_field( $atts['id'] );
	} else {
		$id = '';
	}
	// Validate/whitelist rotate.
	if ( isset( $atts['rotate'] ) ) {
		$rotate = strtolower( sanitize_text_field( $atts['rotate'] ) );
		if ( 'yes' !== $rotate ) {
			$rotate = 'no';
		}
	} else {
		$rotate = 'no';
	}
	// Validate layout.
	if ( isset( $atts['layout'] ) ) {
		$layout_override = sanitize_text_field( $atts['layout'] );
	} else {
		$layout_override = '0';
	}
	// Apply layout overide if applicable.
	if ( '1' === $layout_override ) {
		$content_layout        = 'Top Meta'; // translate ok.
		$use_formatted_display = false;
	} elseif ( '2' === $layout_override ) {
		$content_layout        = 'Bottom Meta'; // translate ok.
		$use_formatted_display = false;
	} elseif ( '3' === $layout_override ) {
		$content_layout        = 'Side Meta'; // translate ok.
		$use_formatted_display = false;
	} elseif ( '4' === $layout_override ) {
		$content_layout        = 'Top Meta'; // translate ok.
		$use_formatted_display = true;
	} elseif ( '5' === $layout_override ) {
		$content_layout        = 'Bottom Meta'; // translate ok.
		$use_formatted_display = true;
	} elseif ( '6' === $layout_override ) {
		$content_layout        = 'Side Meta'; // translate ok.
		$use_formatted_display = true;
	} elseif ( '7' === $layout_override ) {
		$content_layout        = 'Mosaic'; // translate ok.
		$use_formatted_display = false;
	} elseif ( '8' === $layout_override ) {
		$content_layout        = 'Mosaic'; // translate ok.
		$use_formatted_display = true;
	} else {
		$content_layout        = sanitize_text_field( $katb_options['katb_layout_option'] );
		$use_formatted_display = $katb_options['katb_use_formatted_display'];
	}
	// White list schema.
	if ( isset( $atts['schema'] ) ) {
		$use_schema_override = sanitize_text_field( $atts['schema'] );
		if ( 'yes' !== $use_schema_override && 'no' !== $use_schema_override ) {
			$use_schema_override = 'default';
		}
	} else {
		$use_schema_override = 'default';
	}
	// Check use schema override, note that $use_schema is not changed if set to 'default'.
	if ( 'yes' === $use_schema_override ) {
		$use_schema = true;
	} elseif ( 'no' === $use_schema_override ) {
		$use_schema = false;
	} elseif ( true === $use_schema ) {
		$use_schema = true;
	} else {
		$use_schema = false;
	}
	if ( 'Mosaic' === $content_layout ) {
		$katb_rotate = false;
		$rotate      = 'no';
	} elseif ( 'yes' === $rotate ) {
		$katb_rotate = true;
	} else {
		$katb_rotate = false;
	}
	// OK let's start by getting the testimonial data from the database.
	if ( '' !== $id ) {
		// Get the testimonials.
		$katb_tdata_array = katb_get_testimonials_from_ids( $id );
		$katb_tdata       = $katb_tdata_array[0];
		$katb_tnumber     = $katb_tdata_array[1];
	} else {
		// Get the testimonials.
		$use_pagination   = $katb_options['katb_use_pagination'];
		$katb_tdata_array = katb_get_testimonials( $group, $number, $by, $rotate, $use_pagination );
		$katb_tdata       = $katb_tdata_array[0];
		$katb_tnumber     = $katb_tdata_array[1];
		if ( isset( $katb_tdata_array[2] ) ) {
			$katb_paginate_setup = $katb_tdata_array[2];
		}
	}
	$katb_error = '';
	if ( 2 > $katb_tnumber && 'yes' === $rotate ) {
		$katb_error = esc_html__( 'You must have 2 approved testimonials to use a rotated display!', 'testimonial-basics' );
	} elseif ( 0 === $katb_tnumber ) {
		$katb_error = esc_html__( 'There are no approved testimonials to display!', 'testimonial-basics' );
	}
	ob_start();
	if ( '' !== $katb_error ) {
		echo '<div class="katb_error">' . $katb_error . '</div>';// phpcs:ignore
	} else {
		katb_content_display( $use_formatted_display, $use_schema, $katb_tnumber, $katb_tdata, $katb_rotate, $content_layout, $group );
	}
	// Pagination.
	if ( true === $display_reviews && true === $use_schema ) {
		if ( isset( $katb_options['katb_use_pagination'] ) && true === $katb_options['katb_use_pagination'] && isset( $katb_paginate_setup ) ) {
			echo katb_get_display_pagination_string( $katb_paginate_setup, $use_formatted_display );// phpcs:ignore
		}
	} else {
		if ( isset( $katb_options['katb_use_pagination'] ) && true === $katb_options['katb_use_pagination'] && isset( $katb_paginate_setup ) ) {
			echo katb_get_display_pagination_string( $katb_paginate_setup, $use_formatted_display );// phpcs:ignore
		}
	}
	return ob_get_clean();
}
add_shortcode( 'katb_testimonial', 'katb_list_testimonials' );

/**
 * Display testimonial input form shortcode
 *
 * Displays the testimonial input form.
 * useage : [katb_input_testimonials group="All" form="1"]
 *
 * @param array $atts array of shortcode parameters, in this case only the group and form number.
 *
 * @uses katb_get_options() array of plugin user options.
 *
 * @return string $input_html which is the html string for the form.
 */
function katb_display_input_form( $atts ) {
	$katb_options              = katb_get_options();
	$use_gdpr                  = $katb_options['katb_use_gdpr'];
	$gdpr_note                 = $katb_options['katb_gdpr_save_data_note'];
	$author_label              = $katb_options['katb_author_label'];
	$email_label               = $katb_options['katb_email_label'];
	$website_label             = $katb_options['katb_website_label'];
	$location_label            = $katb_options['katb_location_label'];
	$custom1_label             = $katb_options['katb_custom1_label'];
	$custom2_label             = $katb_options['katb_custom2_label'];
	$rating_label              = $katb_options['katb_rating_label'];
	$title_label               = $katb_options['katb_testimonial_title_label'];
	$testimonial_label         = $katb_options['katb_testimonial_label'];
	$captcha_label             = $katb_options['katb_captcha_label'];
	$submit_label              = $katb_options['katb_submit_label'];
	$reset_label               = $katb_options['katb_reset_label'];
	$required_label            = $katb_options['katb_required_label'];
	$exclude_website           = $katb_options['katb_exclude_website_input'];
	$require_website           = $katb_options['katb_require_website_input'];
	$exclude_location          = $katb_options['katb_exclude_location_input'];
	$require_location          = $katb_options['katb_require_location_input'];
	$exclude_custom1           = $katb_options['katb_exclude_custom1_input'];
	$require_custom1           = $katb_options['katb_require_custom1_input'];
	$exclude_custom2           = $katb_options['katb_exclude_custom2_input'];
	$require_custom2           = $katb_options['katb_require_custom2_input'];
	$exclude_testimonial_title = $katb_options['katb_exclude_testimonial_title_input'];
	$require_testimonial_title = $katb_options['katb_require_testimonial_title_input'];
	$use_ratings               = $katb_options['katb_use_ratings'];
	$use_popup                 = $katb_options['katb_use_popup_message'];
	$auto_approve              = $katb_options['katb_auto_approve'];
	$labels_inside             = $katb_options['katb_show_labels_inside'];
	$katb_allowed_html         = katb_allowed_html();
	// Initialize variables.
	if ( true === $labels_inside ) {
		$katb_author      = $author_label;
		$katb_email       = $email_label;
		$katb_website     = $website_label;
		$katb_location    = $location_label;
		$katb_custom1     = $custom1_label;
		$katb_custom2     = $custom2_label;
		$katb_title       = $title_label;
		$katb_testimonial = $testimonial_label;
		$katb_rating      = 0.0;
	} else {
		$katb_author      = '';
		$katb_email       = '';
		$katb_website     = '';
		$katb_location    = '';
		$katb_custom1     = '';
		$katb_custom2     = '';
		$katb_title       = '';
		$katb_testimonial = '';
		$katb_rating      = 0.0;
	}
	// Initialize GDPR switch.
	$gdpr_approved = false;
	// Initiate return string.
	$input_html = '';
	global $wpdb, $tablename, $katb_options;
	// Set up table name for datatbase updates.
	$tablename = $wpdb->prefix . 'testimonial_basics';
	// Get shortcode variables.
	$katb_group         = isset( $atts['group'] ) ? esc_html( $atts['group'] ) : 'All';
	$katb_input_form_no = isset( $atts['form'] ) ? intval( $atts['form'] ) : 1;
	if ( '' === $katb_group ) {
		$katb_group = 'All';
	}
	if ( '' === $katb_input_form_no || 0 === $katb_input_form_no ) {
		$katb_input_form_no = 1;
	}
	// Process the submit.
	if ( isset( $_POST[ 'katb_submitted' . $katb_input_form_no ], $_POST[ 'katb_main_form_nonce' . $katb_input_form_no ] ) && // Input var okay.
		wp_verify_nonce( sanitize_key( $_POST[ 'katb_main_form_nonce' . $katb_input_form_no ] ), 'katb_nonce_1' ) ) {// Input var OK.
		// Check for valid submission.
		$katb_bot_submission = false;
		if ( true === $katb_options['katb_use_honeypot'] ) {
			if ( ! empty( $_POST['tb_custom3'] ) ) { // Input var okay.
				$katb_bot_submission = true;
			}
		}
		// OK to proceed.
		if ( false === $katb_bot_submission ) {
			// Initialize error message.
			$katb_input_error = '';
			// Order is set in admin.
			$katb_order = 0;
			// Auto approve.
			if ( true === $auto_approve ) {
				$katb_approved = 1;
			} else {
				$katb_approved = 0;
			}
			// Time stamp.
			$katb_datetime = current_time( 'mysql' );
			// GDPR approval.
			if ( true === $use_gdpr ) {
				if ( isset( $_POST['tb_gdpr'] ) ) { // Input var okay.
					$gdpr_approved = true;
				} else {
					$gdpr_approved = false;
					if ( true === $use_popup ) {
						$katb_input_error .= '\n - ' . __( 'You must check the box to allow us to save the testimonial data', 'testimonial-basics' );
					} else {
						$katb_input_error .= '<br/> - ' . __( 'You must check the box to allow us to save the testimonial data', 'testimonial-basics' );
					}
				}
			}
			// Author.
			if ( ! empty( $_POST['tb_author'] ) ) { // Input var okay.
				$katb_author = sanitize_text_field( wp_unslash( $_POST['tb_author'] ) ); // Input var okay.
			} else {
				$katb_author = '';
			}
			if ( '' === $katb_author || $katb_author === $author_label ) {
				if ( true === $use_popup ) {
					$katb_input_error .= '\n - ' . __( 'Author is required', 'testimonial-basics' );
				} else {
					$katb_input_error .= '<br/> - ' . __( 'Author is required', 'testimonial-basics' );
				}
				if ( true === $labels_inside ) {
					$katb_author = $author_label;
				} else {
					$katb_author = '';
				}
			}
			// Validate-Sanitize E-mail, note: label will not be an email.
			if ( ! empty( $_POST['tb_email'] ) ) { // Input var okay.
				$katb_email = sanitize_email( wp_unslash( $_POST['tb_email'] ) ); // Input var okay.
			} else {
				$katb_email = '';
			}
			if ( ! is_email( $katb_email ) ) {
				if ( true === $use_popup ) {
					$katb_input_error .= '\n - ' . __( 'Valid email is required', 'testimonial-basics' );
				} else {
					$katb_input_error .= '<br/> - ' . __( 'Valid email is required', 'testimonial-basics' );
				}
				if ( true === $labels_inside ) {
					$katb_email = $email_label;
				} else {
					$katb_email = '';
				}
				if ( true === $labels_inside && '' === $katb_email ) {
					$katb_email = $email_label;
				}
			}
			// Website.
			if ( false === $exclude_website ) {
				if ( ! empty( $_POST['tb_website'] ) ) { // Input var okay.
					$katb_website = esc_url_raw( wp_unslash( $_POST['tb_website'] ) ); // Input var okay.
				} else {
					$katb_website = '';
				}
				if ( '' === $katb_website || $katb_website === $website_label ) {
					if ( true === $require_website ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . __( 'Website is required', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . __( 'Website is required', 'testimonial-basics' );
						}
					}
					if ( true === $labels_inside ) {
						$katb_website = $website_label;
					} else {
						$katb_website = '';
					}
				}
			} else {
				$katb_website = '';
			}
			// Location.
			if ( false === $exclude_location ) {
				if ( ! empty( $_POST['tb_location'] ) ) { // Input var okay.
					$katb_location = sanitize_text_field( wp_unslash( $_POST['tb_location'] ) ); // Input var okay.
				} else {
					$katb_location = '';
				}
				if ( '' === $katb_location || $katb_location === $location_label ) {
					if ( true === $require_location ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . __( 'Location is required', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . __( 'Location is required', 'testimonial-basics' );
						}
					}
					if ( true === $labels_inside ) {
						$katb_location = $location_label;
					} else {
						$katb_location = '';
					}
				}
			} else {
				$katb_location = '';
			}
			// Custom1.
			if ( false === $exclude_custom1 ) {
				if ( ! empty( $_POST['tb_custom1'] ) ) { // Input var okay.
					$katb_custom1 = sanitize_text_field( wp_unslash( $_POST['tb_custom1'] ) ); // Input var okay.
				} else {
					$katb_custom1 = '';
				}
				if ( '' === $katb_custom1 || $katb_custom1 === $custom1_label ) {
					if ( true === $require_custom1 ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . esc_html( $custom1_label ) . ' ' . __( 'is required', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . esc_html( $custom1_label ) . ' ' . __( 'is required', 'testimonial-basics' );
						}
					}
					if ( true === $labels_inside ) {
						$katb_custom1 = $custom1_label;
					} else {
						$katb_custom1 = '';
					}
				}
			} else {
				$katb_custom1 = '';
			}
			// Custom2.
			if ( false === $exclude_custom2 ) {
				if ( ! empty( $_POST['tb_custom2'] ) ) { // Input var okay.
					$katb_custom2 = sanitize_text_field( wp_unslash( $_POST['tb_custom2'] ) ); // Input var okay.
				} else {
					$katb_custom2 = '';
				}
				if ( '' === $katb_custom2 || $katb_custom2 === $custom2_label ) {
					if ( true === $require_custom2 ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . esc_html( $custom2_label ) . ' ' . __( 'is required', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . esc_html( $custom2_label ) . ' ' . __( 'is required', 'testimonial-basics' );
						}
					}
					if ( true === $labels_inside ) {
						$katb_custom2 = $custom2_label;
					} else {
						$katb_custom2 = '';
					}
				}
			} else {
				$katb_custom2 = '';
			}
			// Rating.
			if ( true === $use_ratings ) {
				if ( ! empty( $_POST['tb_rating'] ) ) { // Input var okay.
					$katb_rating = sanitize_text_field( wp_unslash( $_POST['tb_rating'] ) ); // Input var okay.
				} else {
					$katb_rating = '0.0';
				}
				if ( '' === $katb_rating ) {
					$katb_rating = '0.0';
				}
				if ( '0' === $katb_rating ) {
					$katb_rating = '0.0';
				}
				if ( '1' === $katb_rating ) {
					$katb_rating = '1.0';
				}
				if ( '2' === $katb_rating ) {
					$katb_rating = '2.0';
				}
				if ( '3' === $katb_rating ) {
					$katb_rating = '3.0';
				}
				if ( '4' === $katb_rating ) {
					$katb_rating = '4.0';
				}
				if ( '5' === $katb_rating ) {
					$katb_rating = '5.0';
				}
			} else {
				$katb_rating = '0.0';
			}
			// Captcha.
			if ( true === $katb_options['katb_use_captcha'] ) {
				if ( true === $katb_options['katb_use_recaptcha'] ) {
					if ( ! empty( $_POST['g-recaptcha-response'] ) ) { // Input var okay.
						$captcha_response = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ); // Input var okay.
					} else {
						$captcha_response = false;
					}
					if ( false === $captcha_response ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . __( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . __( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
						}
					} else {
						$secret_key      = esc_html( $katb_options['katb_secret_key'] );
						$request         = wp_safe_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $captcha_response );
						$verify_response = wp_remote_retrieve_body( $request );
						$response_data   = json_decode( $verify_response );
						if ( false === $response_data->success ) {
							if ( true === $use_popup ) {
								$katb_input_error .= '\n - ' . __( 'Captcha failed - please try again', 'testimonial-basics' );
							} else {
								$katb_input_error .= '<br/> - ' . __( 'Captcha failed - please try again', 'testimonial-basics' );
							}
						}
					}
				} else {
					if ( ! empty( $_POST['verify'] ) ) { // Input var okay.
						$katb_captcha_entered = sanitize_text_field( wp_unslash( $_POST['verify'] ) ); // Input var okay.
					} else {
						$katb_captcha_entered = '';
					}
					if ( get_transient( 'katb_pass_phrase_content' . $katb_input_form_no ) !== sha1( $katb_captcha_entered ) ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . __( 'Captcha is invalid - please try again', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . __( 'Captcha is invalid - please try again', 'testimonial-basics' );
						}
					}
				}
			}
			// Testimonial title.
			if ( false === $exclude_testimonial_title ) {
				if ( ! empty( $_POST['tb_title'] ) ) { // Input var okay.
					$katb_title = sanitize_text_field( wp_unslash( $_POST['tb_title'] ) ); // Input var okay.
				} else {
					$katb_title = '';
				}
				if ( '' === $katb_title || $katb_title === $title_label ) {
					if ( true === $require_testimonial_title ) {
						if ( true === $use_popup ) {
							$katb_input_error .= '\n - ' . __( 'Testimonial title is required', 'testimonial-basics' );
						} else {
							$katb_input_error .= '<br/> - ' . __( 'Testimonial title is required', 'testimonial-basics' );
						}
					}
					if ( true === $labels_inside ) {
						$katb_title = $title_label;
					} else {
						$katb_title = '';
					}
				}
			} else {
				$katb_title = '';
			}
			// Validate testimonial.
			// Check for error before processing to avoid html encoding until all is good.
			// Premature encoding causes wp_kses to remove smiley images on second pass.
			if ( '' === $katb_input_error ) {
				// Sanitize first.
				if ( ! empty( $_POST['tb_testimonial'] ) ) { // Input var okay.
					$katb_sanitize_testimonial = wp_kses( wp_unslash( $_POST['tb_testimonial'] ), $katb_allowed_html ); // Input var okay.
					// Add WordPress Smiley support.
					$katb_fix_emoticons = convert_smilies( $katb_sanitize_testimonial );
					// If emoji present convert to html entities.
					$katb_testimonial = wp_encode_emoji( $katb_fix_emoticons );
				} else {
					$katb_testimonial = '';
				}
			} else {
				$katb_testimonial = wp_kses( wp_unslash( $_POST['tb_testimonial'] ), $katb_allowed_html ); // Input var okay.
			}
			if ( '' === $katb_testimonial || $katb_testimonial === $testimonial_label ) {
				if ( true === $use_popup ) {
					$katb_input_error .= '\n - ' . __( 'Testimonial is required', 'testimonial-basics' );
				} else {
					$katb_input_error .= '<br/> - ' . __( 'Testimonial is required', 'testimonial-basics' );
				}
				if ( true === $labels_inside ) {
					$katb_testimonial = $testimonial_label;
				} else {
					$katb_testimonial = '';
				}
			}
			// Validation complete.
			if ( '' === $katb_input_error ) {
				// OK to update the database.
				// First remove label entries if they exist.
				if ( $katb_location === $location_label ) {
					$katb_location = '';
				}
				if ( $katb_website === $website_label ) {
					$katb_website = '';
				}
				if ( $katb_custom1 === $custom1_label ) {
					$katb_custom1 = '';
				}
				if ( $katb_custom2 === $custom2_label ) {
					$katb_custom2 = '';
				}
				if ( $katb_title === $title_label ) {
					$katb_title = '';
				}
				// Set the values.
				$values         = array(
					'tb_date'        => $katb_datetime,
					'tb_order'       => $katb_order,
					'tb_approved'    => $katb_approved,
					'tb_group'       => $katb_group,
					'tb_name'        => $katb_author,
					'tb_email'       => $katb_email,
					'tb_location'    => $katb_location,
					'tb_custom1'     => $katb_custom1,
					'tb_custom2'     => $katb_custom2,
					'tb_url'         => $katb_website,
					'tb_pic_url'     => '',
					'tb_rating'      => $katb_rating,
					'tb_title'       => $katb_title,
					'tb_testimonial' => $katb_testimonial,
				);
				$formats_values = array( '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
				$wpdb->insert( $tablename, $values, $formats_values ); // WPCS: db call ok.
				// Send notification email.
				katb_email_notification( $katb_author, $katb_email, $katb_testimonial );
				// Success message.
				if ( true === $use_popup ) { ?>
					<script><?php echo 'alert( "' . esc_html__( 'Testimonial Submitted - Thank You!', 'testimonial-basics' ) . '" )'; ?></script>
					<?php
				} else {
					$input_html .= '<span class="katb_test_sent">' . esc_html__( 'Testimonial Submitted - Thank You!', 'testimonial-basics' ) . '</span>';
				}
				// Reset the variables.
				if ( true === $labels_inside ) {
					$katb_author      = $author_label;
					$katb_email       = $email_label;
					$katb_website     = $website_label;
					$katb_location    = $location_label;
					$katb_custom1     = $custom1_label;
					$katb_custom2     = $custom2_label;
					$katb_title       = $title_label;
					$katb_testimonial = $testimonial_label;
				} else {
					$katb_author      = '';
					$katb_email       = '';
					$katb_website     = '';
					$katb_location    = '';
					$katb_custom1     = '';
					$katb_custom2     = '';
					$katb_title       = '';
					$katb_testimonial = '';
				}
			} else {
				// There is an error somewhere.
				if ( true === $use_popup ) {
					$error_message = esc_html__( 'There were errors so the testimonial was not added: ', 'testimonial-basics' ) . $katb_input_error;// phpcs:ignore
					?>
					<script>alert("<?php echo $error_message;// phpcs:ignore ?>")</script>
					<?php
				} else {
					$input_html .= '<span class="katb_error">' . esc_html__( 'There were errors so the testimonial was not added: ', 'testimonial-basics' ) . $katb_input_error . '</span>';// phpcs:ignore
				}
			}
		}
	}
	/* ---------- Reset button is clicked ---------------- */
	if ( isset( $_POST['katb_reset'] ) ) { // Input var okay.
		// Initialize Variables.
		if ( true === $labels_inside ) {
			$katb_author      = $author_label;
			$katb_email       = $email_label;
			$katb_website     = $website_label;
			$katb_location    = $location_label;
			$katb_custom1     = $custom1_label;
			$katb_custom2     = $custom2_label;
			$katb_title       = $title_label;
			$katb_testimonial = $testimonial_label;
		} else {
			$katb_author      = '';
			$katb_email       = '';
			$katb_website     = '';
			$katb_location    = '';
			$katb_custom1     = '';
			$katb_custom2     = '';
			$katb_title       = '';
			$katb_testimonial = '';
		}
		// Other variables.
		$katb_id       = '';
		$katb_order    = '';
		$katb_approved = '';
		$katb_date     = '';
		$katb_time     = '';
		$katb_rating   = '0.0';
	}
	// Input Form.
	// Form title.
	$input_html .= '<div class="katb_input_style">';
	if ( true === $katb_options['katb_include_input_title'] ) {
		$input_html .= '<h1 class="katb_content_input_title">' . esc_html( stripcslashes( $katb_options['katb_input_title'] ) ) . '</h1>';
	}
	// Email note.
	if ( true === $katb_options['katb_include_email_note'] ) {
		$input_html .= '<span class="katb_email_note">' . esc_html( stripcslashes( $katb_options['katb_email_note'] ) ) . '</span>';
	}
	$input_html .= '<form method="POST">';
	// GDPR approval.
	if ( true === $use_gdpr ) {
		$input_html .= '<span class="content-gdpr-approve">';
		$input_html .= '<input class="gdpr-checkbox" type="checkbox" name="tb_gdpr" id="gdpr_checkbox-id"' . checked( $gdpr_approved, true, false ) . '>';
		$input_html .= '<span class="gdpr-label">';
		$input_html .= ' ' . esc_html( $gdpr_note );
		$input_html .= '</span>';
		$input_html .= '</span>';
	}
	// Author.
	if ( false === $labels_inside ) {
		$input_html .= '<label class="katb_input_label1">' . esc_html( $author_label ) . '</label>';
	}
	if ( $katb_author === $author_label || '' === $katb_author ) {
		$input_html .= '<input type="text"  maxlength="100" name="tb_author" placeholder="' . esc_attr( stripcslashes( $katb_author ) ) . '" /><br/>';
	} else {
		$input_html .= '<input type="text"  maxlength="100" name="tb_author" value="' . esc_attr( stripcslashes( $katb_author ) ) . '" /><br/>';
	}
	// Email.
	if ( false === $labels_inside ) {
		$input_html .= '<label class="katb_input_label1">' . esc_html( $email_label ) . '</label>';
	}
	if ( $katb_email === $email_label || '' === $katb_email ) {
		$input_html .= '<input type="text"  maxlength="100" name="tb_email" placeholder="' . esc_attr( stripcslashes( $katb_email ) ) . ' " /><br/>';
	} else {
		$input_html .= '<input type="text"  maxlength="100" name="tb_email" value="' . esc_attr( stripcslashes( $katb_email ) ) . ' " /><br/>';
	}
	// Website.
	if ( false === $exclude_website ) {
		if ( false === $labels_inside ) {
			$input_html .= '<label class="katb_input_label1">' . esc_html( $website_label ) . '</label>';
			if ( '' === $katb_website || $katb_website === $website_label || 'http://' . $website_label === $katb_website ) {
				$input_html .= '<input type="text"  maxlength="100" name="tb_website" placeholder="' . esc_url( stripcslashes( $katb_website ) ) . '" /><br/>';
			} else {
				$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="' . esc_url( stripcslashes( $katb_website ) ) . '" /><br/>';
			}
		} else {
			if ( '' === $katb_website || $katb_website === $website_label || 'http://' . $website_label === $katb_website ) {
				$input_html .= '<input type="text"  maxlength="100" name="tb_website" placeholder="' . $website_label . '" /><br/>';
			} else {
				$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="' . esc_url( stripcslashes( $katb_website ) ) . '" /><br/>';
			}
		}
	}
	// Location.
	if ( false === $exclude_location ) {
		if ( false === $labels_inside ) {
			$input_html .= '<label class="katb_input_label1">' . esc_html( $location_label ) . '</label>';
		}
		if ( $katb_location === $location_label || '' === $katb_location ) {
			$input_html .= '<input type="text"  maxlength="100" name="tb_location" placeholder="' . esc_attr( stripcslashes( $katb_location ) ) . '" /><br/>';
		} else {
			$input_html .= '<input type="text"  maxlength="100" name="tb_location" value="' . esc_attr( stripcslashes( $katb_location ) ) . '" /><br/>';
		}
	}
	// Custom 1.
	if ( false === $exclude_custom1 ) {
		if ( false === $labels_inside ) {
			$input_html .= '<label class="katb_input_label1">' . esc_html( $custom1_label ) . '</label>';
		}
		if ( $katb_custom1 === $custom1_label || '' === $katb_custom1 ) {
			$input_html .= '<input type="text"  maxlength="100" name="tb_custom1" placeholder="' . esc_attr( stripcslashes( $katb_custom1 ) ) . '" /><br/>';
		} else {
			$input_html .= '<input type="text"  maxlength="100" name="tb_custom1" value="' . esc_attr( stripcslashes( $katb_custom1 ) ) . '" /><br/>';
		}
	}
	// Custom 2.
	if ( false === $exclude_custom2 ) {
		if ( false === $labels_inside ) {
			$input_html .= '<label class="katb_input_label1">' . esc_html( $custom2_label ) . '</label>';
		}
		if ( $katb_custom2 === $custom2_label || '' === $katb_custom2 ) {
			$input_html .= '<input type="text"  maxlength="100" name="tb_custom2" placeholder="' . esc_attr( stripcslashes( $katb_custom2 ) ) . '" /><br/>';
		} else {
			$input_html .= '<input type="text"  maxlength="100" name="tb_custom2" value="' . esc_attr( stripcslashes( $katb_custom2 ) ) . '" /><br/>';
		}
	}
	// Rating.
	if ( true === $use_ratings ) {
		if ( '' === $katb_rating ) {
			$katb_rating = '0.0';
		}
		$input_html .= '<span class="katb_input_rating">';
		$input_html .= '<label class="katb_input_label1">' . esc_attr( $rating_label ) . '</label>';
		$input_html .= '<select name="tb_rating" class="katb_css_rating_select">';
		$input_html .= '<option value="0.0" ' . selected( esc_attr( $katb_rating ), '0.0', false ) . '>0.0</option>';
		$input_html .= '<option value="0.5" ' . selected( esc_attr( $katb_rating ), '0.5', false ) . '>0.5</option>';
		$input_html .= '<option value="1.0" ' . selected( esc_attr( $katb_rating ), '1.0', false ) . '>1.0</option>';
		$input_html .= '<option value="1.5" ' . selected( esc_attr( $katb_rating ), '1.5', false ) . '>1.5</option>';
		$input_html .= '<option value="2.0" ' . selected( esc_attr( $katb_rating ), '2.0', false ) . '>2.0</option>';
		$input_html .= '<option value="2.5" ' . selected( esc_attr( $katb_rating ), '2.5', false ) . '>2.5</option>';
		$input_html .= '<option value="3.0" ' . selected( esc_attr( $katb_rating ), '3.0', false ) . '>3.0</option>';
		$input_html .= '<option value="3.5" ' . selected( esc_attr( $katb_rating ), '3.5', false ) . '>3.5</option>';
		$input_html .= '<option value="4.0" ' . selected( esc_attr( $katb_rating ), '4.0', false ) . '>4.0</option>';
		$input_html .= '<option value="4.5" ' . selected( esc_attr( $katb_rating ), '4.5', false ) . '>4.5</option>';
		$input_html .= '<option value="5.0" ' . selected( esc_attr( $katb_rating ), '5.0', false ) . '>5.0</option>';
		$input_html .= '</select>';
		$input_html .= '</span>';
	}
	// Testimonial title.
	if ( false === $exclude_testimonial_title ) {
		if ( false === $labels_inside ) {
			$input_html .= '<label class="katb_input_label2">' . esc_html( $title_label ) . '</label>';
		}
		if ( $katb_title === $title_label || '' === $katb_title ) {
			$input_html .= '<input class="katb_title_input" type="text"  name="tb_title" placeholder=" ' . esc_attr( stripcslashes( $katb_title ) ) . '" /><br/>';
		} else {
			$input_html .= '<input class="katb_title_input" type="text"  name="tb_title" value=" ' . esc_attr( stripcslashes( $katb_title ) ) . '" /><br/>';
		}
	}
	// Testimonial.
	if ( false === $labels_inside ) {
		$input_html .= '<label class="katb_input_label2">' . esc_attr( $testimonial_label ) . '</label><br/>';
	}
	if ( $katb_testimonial === $testimonial_label || '' === $katb_testimonial ) {
		$input_html .= '<textarea class="katb-input-textarea" rows="5" name="tb_testimonial" placeholder="' . wp_kses_post( stripcslashes( $katb_testimonial ) ) . '"></textarea>';
	} else {
		$input_html .= '<textarea class="katb-input-textarea" rows="5" name="tb_testimonial" >' . wp_kses_post( stripcslashes( $katb_testimonial ) ) . '</textarea>';
	}
	// Show html allowed.
	if ( true === $katb_options['katb_show_html_content'] ) {
		$input_html .= '<span class="katb_content_html_allowed">HTML ' . esc_html__( 'Allowed', 'testimonial-basics' ) . ' : <code>a p br i em strong q h1-h6</code></span>';
	}
	// Captcha.
	if ( true === $katb_options['katb_use_captcha'] ) {
		$input_html .= '<div class="katb_captcha">';
		if ( true === $katb_options['katb_use_recaptcha'] ) {
			$site_key    = $katb_options['katb_site_key'];
			$input_html .= '<div id="content_captcha_' . $katb_input_form_no . '" ' .
							'class="g-recaptcha" ' .
							'data-captchaid="katb_content_captchaid_' . $katb_input_form_no . '" ' .
							'data-sitekey="' . esc_html( $site_key ) . '"' .
							'></div>';
		} elseif ( true === $katb_options['katb_use_color_captcha_2'] ) {
			$input_html .= katb_color_captcha_2( 'content', $katb_input_form_no );
			$input_html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		} elseif ( true === $katb_options['katb_use_color_captcha'] ) {
			$input_html .= katb_color_captcha( 'content', $katb_input_form_no );
			$input_html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		} else {
			$input_html .= katb_bw_captcha( 'content', $katb_input_form_no );
			$input_html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		}
		$input_html .= '</div>';
	}
	// Submit and Reset.
	$input_html .= '<span class="katb_submit_reset">';
	$input_html .= '<input type="hidden" name="katb_form_no" value="' . $katb_input_form_no . '">';
	$input_html .= '<input class="katb_submit" type="submit" name="katb_submitted' . $katb_input_form_no . '" value="' . esc_attr( $submit_label ) . '" />';
	$input_html .= '<input class="katb_reset" type="submit" name="katb_reset" value="' . esc_attr( $reset_label ) . '" />';
	$input_html .= wp_nonce_field( 'katb_nonce_1', 'katb_main_form_nonce' . $katb_input_form_no, false, false );
	$input_html .= '</span>';
	if ( true === $katb_options['katb_use_honeypot'] ) {
		$input_html .= '<span class="katb_span_custom3">' . esc_html__( 'This input should not be filled out', 'testimonial-basics' );
		$input_html .= '<input class="custom_3" type="text" maxlength="100" name="tb_custom3" value="" tabindex="-1" autocomplete="off" />';
		$input_html .= '</span>';
	}
	$input_html .= '</form>';
	// Requires text.
	$input_html .= '<span class="katb_required_label">' . esc_attr( $required_label ) . '</span>';
	// Gravatar link.
	if ( true === $katb_options['katb_show_gravatar_link'] ) {
		$input_html         .= '<span class="katb_add_photo">' . esc_html__( 'Add a photo? ', 'testimonial-basics' );
			$input_html     .= '<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >';
				$input_html .= '<img class="gravatar_logo" src="' . plugin_dir_url( __FILE__ ) . 'Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />';
			$input_html     .= '</a>';
		$input_html         .= '</span>';
	}
	$input_html .= '</div>';
	return $input_html;
}
add_shortcode( 'katb_input_testimonials', 'katb_display_input_form' );

/**
 * Request to remove testimonial shortcode
 *
 * Displays the form to allow users to submit a request for testimonial removal.
 * useage : [katb_remove_testimonial]
 *
 * @uses katb_get_options() array of plugin user options.
 *
 * @return string $input_html which is the html string for the form.
 */
function katb_remove_testimonial_form() {
	// Get the testimonial id.
	$id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : false; // Input var okay.
	// Initiate return string.
	$html = '';
	global $katb_options;
	$author_label       = $katb_options['katb_author_label'];
	$email_label        = $katb_options['katb_email_label'];
	$website_label      = $katb_options['katb_website_label'];
	$location_label     = $katb_options['katb_location_label'];
	$custom1_label      = $katb_options['katb_custom1_label'];
	$custom2_label      = $katb_options['katb_custom2_label'];
	$rating_label       = $katb_options['katb_rating_label'];
	$title_label        = $katb_options['katb_testimonial_title_label'];
	$testimonial_label  = $katb_options['katb_testimonial_label'];
	$captcha_label      = $katb_options['katb_captcha_label'];
	$submit_label       = $katb_options['katb_submit_label'];
	$use_popup          = $katb_options['katb_use_popup_message'];
	$intro_msg          = $katb_options['katb_remove_page_intro'];
	$no_testimonial_msg = $katb_options['katb_remove_page_direct_access'];
	// Get testimonial
	// initialize.
	$count               = 0;
	$katb_remover_email  = '';
	$katb_remover_reason = '';
	global $wpdb, $katb_options;
	if ( false !== $id ) {
		$katb_tdata_array = katb_get_testimonials_from_ids( $id );
		$katb_tdata       = $katb_tdata_array[0];
		$count            = $katb_tdata_array[1];
	} else {
		$katb_tdata = false;
		$count      = 0;
	}
	if ( 1 === $count ) {
		$date          = esc_html( $katb_tdata[0]['tb_date'] );
		$date_string   = date_i18n( get_option( 'date_format' ), strtotime( $date ) );
		$html         .= '<div id="katb-remove-testimonial-wrap">';
			$html     .= '<div class="katb-remove-intro">';
				$html .= esc_html( $intro_msg );
			$html     .= '</div>';
			$html     .= '<div class="katb-remove-testimonial-details">';
				$html .= '<span class="katb-remove title">' . esc_html__( 'Title : ', 'testimonial-basics' ) . esc_html( $katb_tdata[0]['tb_title'] ) . '</span>';
				$html .= '<span class="katb-remove rating">' . esc_html( $rating_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_rating'] ) . '</span>';
				$html .= '<span class="katb-remove author">' . esc_html( $author_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_name'] ) . '</span>';
				$html .= '<span class="katb-remove date">' . esc_html__( 'Date: ', 'testimonial-basics' ) . ' : ' . $date_string . '</span>';
				$html .= '<span class="katb-remove location">' . esc_html( $location_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_location'] ) . '</span>';
				$html .= '<span class="katb-remove custom1">' . esc_html( $custom1_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_custom1'] ) . '</span>';
				$html .= '<span class="katb-remove custom2">' . esc_html( $custom1_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_custom2'] ) . '</span>';
				$html .= '<span class="katb-remove website">' . esc_html( $website_label ) . ' : ' . esc_html( $katb_tdata[0]['tb_url'] ) . '</span>';
				$html .= '<span class="katb-remove-testimonial-label">' . esc_html( $testimonial_label ) . '</span>';
				$html .= '<span class="katb-remove testimonial">' . wp_kses_post( $katb_tdata[0]['tb_testimonial'] ) . '</span>';
			$html     .= '</div>';
		$html         .= '</div>';
	} else {
		$html         .= '<div id="katb-remove-testimonial-wrap">';
			$html     .= '<div class="katb-remove-intro">';
				$html .= esc_html( $intro_msg );
			$html     .= '</div>';
			$html     .= '<div class="katb-remove-testimonial-details">';
				$html .= esc_html( $no_testimonial_msg );
			$html     .= '</div>';
		$html         .= '</div>';
	}
	// Simpler to adopt as form 1, beause of using functions that need this.
	$katb_input_form_no = 1;
	// Process the submit.
	if ( isset( $_POST['katb_remove_submitted'], $_POST['katb_main_form_nonce'] ) && // Input var okay.
		wp_verify_nonce( sanitize_key( $_POST['katb_main_form_nonce'] ), 'katb_nonce_1' ) ) {// Input var OK.
		// Check for valid submission.
		$katb_bot_submission = false;
		if ( true === $katb_options['katb_use_honeypot'] ) {
			if ( ! empty( $_POST['tb_custom3'] ) ) { // Input var okay.
				$katb_bot_submission = true;
			}
		}
		// OK to proceed.
		if ( false === $katb_bot_submission ) {
			// Initialize error message.
			$katb_remove_error = '';
			// Validate-Sanitize E-mail, note: label will not be an email.
			if ( ! empty( $_POST['remove_request_email'] ) ) { // Input var okay.
				$katb_remover_email = sanitize_email( wp_unslash( $_POST['remove_request_email'] ) ); // Input var okay.
			} else {
				$katb_remover_email = '';
			}
			if ( ! is_email( $katb_remover_email ) ) {
				if ( true === $use_popup ) {
					$katb_remove_error .= '\n - ' . __( 'Valid email is required', 'testimonial-basics' );
				} else {
					$katb_remove_error .= '<br/> - ' . __( 'Valid email is required', 'testimonial-basics' );
				}
			}
			// Captcha.
			if ( true === $katb_options['katb_use_captcha'] ) {
				if ( true === $katb_options['katb_use_recaptcha'] ) {
					if ( ! empty( $_POST['g-recaptcha-response'] ) ) { // Input var okay.
						$captcha_response = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ); // Input var okay.
					} else {
						$captcha_response = false;
					}
					if ( false === $captcha_response ) {
						if ( true === $use_popup ) {
							$katb_remove_error .= '\n - ' . __( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
						} else {
							$katb_remove_error .= '<br/> - ' . __( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
						}
					} else {
						$secret_key      = esc_html( $katb_options['katb_secret_key'] );
						$request         = wp_safe_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $captcha_response );
						$verify_response = wp_remote_retrieve_body( $request );
						$response_data   = json_decode( $verify_response );
						if ( false === $response_data->success ) {
							if ( true === $use_popup ) {
								$katb_remove_error .= '\n - ' . __( 'Captcha failed - please try again', 'testimonial-basics' );
							} else {
								$katb_remove_error .= '<br/> - ' . __( 'Captcha failed - please try again', 'testimonial-basics' );
							}
						}
					}
				} else {
					if ( ! empty( $_POST['verify'] ) ) { // Input var okay.
						$katb_captcha_entered = sanitize_text_field( wp_unslash( $_POST['verify'] ) ); // Input var okay.
					} else {
						$katb_captcha_entered = '';
					}
					if ( get_transient( 'katb_pass_phrase_content' . $katb_input_form_no ) !== sha1( $katb_captcha_entered ) ) {
						if ( true === $use_popup ) {
							$katb_remove_error .= '\n - ' . __( 'Captcha is invalid - please try again', 'testimonial-basics' );
						} else {
							$katb_remove_error .= '<br/> - ' . __( 'Captcha is invalid - please try again', 'testimonial-basics' );
						}
					}
				}
			}
			// Validate remover reason.
			if ( ! empty( $_POST['remover_reason'] ) ) { // Input var okay.
				$katb_remover_reason = sanitize_text_field( wp_unslash( $_POST['remover_reason'] ) ); // Input var okay.
			} else {
				$katb_remover_reason = '';
			}
			// Validation complete.
			if ( '' === $katb_remove_error ) {
				// Send notification email.
				katb_remove_testimonial_request( $katb_remover_email, $katb_remover_reason, $katb_tdata );
				// Success message.
				if ( true === $use_popup ) {
					?>
					<script>
						<?php echo 'alert( "' . esc_html__( 'Request Submitted - Thank You!', 'testimonial-basics' ) . '" )'; ?>
					</script>
					<?php
				} else {
					$html .= '<span class="katb_test_sent">' . esc_html__( 'Request Submitted - Thank You!', 'testimonial-basics' ) . '</span>';
				}
				// Reset the variables.
				$katb_remover_email  = '';
				$katb_remover_reason = '';
			} else {
				// There is an error somewhere.
				if ( true === $use_popup ) {
					$error_message = esc_html__( 'There were errors so the request was not sent: ', 'testimonial-basics' ) . $katb_remove_error;
					?>
					<script>alert("<?php echo $error_message;// phpcs:ignore ?>")</script>
					<?php
				} else {
					$html .= '<span class="katb_error">' . esc_html__( 'There were errors so the request was not sent: ', 'testimonial-basics' ) . $katb_remove_error . '</span>';// phpcs:ignore
				}
			}
		}
	}
	// Remove Form.
	$html .= '<form class="katb-remove-form" method="POST">';
	// Email.
	$html .= '<label class="katb-remove-email-label">' . esc_html( $email_label ) . '</label>';
	$html .= '<input type="text" size="75" name="remove_request_email" value="' . esc_attr( stripcslashes( $katb_remover_email ) ) . ' " /><br/>';
	// Comment or reason.
	$html .= '<label class="katb-remove-comment-label">' . esc_html__( 'Comment or reason for removal:', 'testimonial-basics' ) . '</label><br/>';
	$html .= '<textarea class="katb-input-textarea" rows="5" name="remover_reason" >' . esc_html( stripcslashes( $katb_remover_reason ) ) . '</textarea>';
	// Captcha.
	if ( true === $katb_options['katb_use_captcha'] ) {
		$html .= '<div class="katb_captcha">';
		if ( true === $katb_options['katb_use_recaptcha'] ) {
			$site_key = $katb_options['katb_site_key'];
			$html    .= '<div id="content_captcha_' . $katb_input_form_no . '" ' .
							'class="g-recaptcha" ' .
							'data-captchaid="katb_content_captchaid_' . $katb_input_form_no . '" ' .
							'data-sitekey="' . esc_html( $site_key ) . '"' .
							'></div>';
		} elseif ( true === $katb_options['katb_use_color_captcha_2'] ) {
			$html .= katb_color_captcha_2( 'content', $katb_input_form_no );
			$html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		} elseif ( true === $katb_options['katb_use_color_captcha'] ) {
			$html .= katb_color_captcha( 'content', $katb_input_form_no );
			$html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		} else {
			$html .= katb_bw_captcha( 'content', $katb_input_form_no );
			$html .= '<input type="text" id="verify_' . $katb_input_form_no . '" name="verify" value="' . $captcha_label . '" onclick="this.select();" />';
		}
		$html .= '</div>';
	}
	// Submit and Reset.
	$html .= '<span class="katb-remove-submit-wrap">';
	$html .= '<input class="katb-remove-submit" type="submit" name="katb_remove_submitted" value="' . esc_attr( $submit_label ) . '" />';
	$html .= wp_nonce_field( 'katb_nonce_1', 'katb_main_form_nonce', false, false );
	$html .= '</span>';
	if ( true === $katb_options['katb_use_honeypot'] ) {
		$html .= '<span class="katb_span_custom3">' . esc_html__( 'This input should not be filled out', 'testimonial-basics' );
		$html .= '<input class="custom_3" type="text" maxlength="100" name="tb_custom3" value="" tabindex="-1" autocomplete="off" />';
		$html .= '</span>';
	}
	$html .= '</form>';
	return $html;
}
add_shortcode( 'katb_remove_testimonial', 'katb_remove_testimonial_form' );
