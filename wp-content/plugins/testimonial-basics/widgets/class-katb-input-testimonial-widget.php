<?php
/**
 * Plugin Name: Testimonial Basics Input Widget
 * Plugin URI: https://kevinsspace.ca/testimonial-basics-user-documentation/testimonial-basics-wordpress-plugin/
 * Description: A plugin to input a testimonial.
 * Version: 4.5.1
 * Author: Kevin Archibald
 * Author URI: http://kevinsspace.ca/
 * License: GPLv3
 *
 * @package   Testimonial Basics WordPress Plugin
 * @copyright Copyright (C) 2020 or later Kevin Archibald
 * @license   http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author    Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/**
 * Register Widget
 *
 * The widget is registered using the widgets_init action hook that fires
 * after all default widgets have been registered.
 * katb_input_testimonial_widget is the Class for the widget, all widgets
 * must be created using the WP_Widget Class.
 */
function katb_input_register_register_widget() {
	register_widget( 'katb_input_testimonial_widget' );
}
add_action( 'widgets_init', 'katb_input_register_register_widget' );

/**
 * Widget Class
 *
 * Define Testimonial Basics Input Widget.
 */
class KATB_Input_Testimonial_Widget extends WP_Widget {
	/**
	 * Construct
	 *
	 * The first function is required to process the widget
	 * It sets up an array to store widget options
	 * 'classname' - added to <li class="classnamne"> of the widget html
	 * 'description' - displays under Appearance => Widgets ...your widget
	 * WP_Widget(widget list item ID,Widget Name to be shown on grag bar, options array)
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'katb_input_widget_class',
			'description' => esc_html__( 'Allow a user to input a testimonial.', 'testimonial-basics' ),
		);
		parent::__construct( 'katb_input_testimonial_widget', esc_html__( 'Testimonial Input Widget', 'testimonial-basics' ), $widget_ops );
	}

	/**
	 * Form
	 *
	 * The second function creates the widget setting form.
	 * Each widget has a table in the Options database for it's options
	 * The array of options is $instance. The first thing we do is check to see
	 * if the title instance exists, if so use it otherwise load the default.
	 * The second part displays the title in the widget.
	 *
	 * @param array $instance contains widget form initialization data.
	 */
	public function form( $instance ) {
		$katb_input_defaults = array(
			'katb_input_widget_title'   => __( 'Add a Testimonial', 'testimonial-basics' ),
			'katb_input_widget_group'   => 'All',
			'katb_input_widget_form_no' => '1',
		);
		$instance            = wp_parse_args( (array) $instance, $katb_input_defaults );
		$title               = $instance['katb_input_widget_title'];
		$group               = $instance['katb_input_widget_group'];
		$form                = $instance['katb_input_widget_form_no'];
		?>
		<p>
			<?php esc_html_e( 'Title :', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_title' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Group :', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_group' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_group' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $group ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Form No :', 'testimonial-basics' ); ?>
			<select
				id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_form_no' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_form_no' ) ); ?>">
					<option <?php selected( esc_attr( $form ) ); ?> value="<?php echo esc_attr( $form ); ?>"><?php echo esc_html( $form ); ?></option>
					<option value="1" <?php selected( esc_attr( $form ), '1' ); ?>>1</option>
					<option value="2" <?php selected( esc_attr( $form ), '2' ); ?>>2</option>
					<option value="3" <?php selected( esc_attr( $form ), '3' ); ?>>3</option>
					<option value="4" <?php selected( esc_attr( $form ), '4' ); ?>>4</option>
					<option value="5" <?php selected( esc_attr( $form ), '5' ); ?>>5</option>
			</select>
		</p>
		<?php
	}
	/**
	 * Update
	 *
	 * The third function saves the widget settings.
	 *
	 * @param array $new_instance is array of new instance data.
	 * @param array $old_instance is array of old instance data.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                              = $old_instance;
		$instance['katb_input_widget_title']   = sanitize_text_field( $new_instance['katb_input_widget_title'] );
		$instance['katb_input_widget_group']   = sanitize_text_field( $new_instance['katb_input_widget_group'] );
		$instance['katb_input_widget_form_no'] = sanitize_text_field( $new_instance['katb_input_widget_form_no'] );
		// group validation/whitelist.
		if ( '' === $instance['katb_input_widget_group'] ) {
			$instance['katb_input_widget_group'] = 'All';
		}
		// form validation/whitelist.
		if ( '' === $instance['katb_input_widget_form_no'] ) {
			$instance['katb_input_widget_form_no'] = '1';
		}
		return $instance;
	}
	/**
	 * Display Widget
	 *
	 * The input form for the testimonial widget is loaded. The visitor inputs a testimonial
	 * and clicks the submit button and the testimonial is submitted to the database
	 * and the admin user is notified by email that they have a testimonial to review
	 * and approve. If admin user can specify if a captcha is used to help in validation.
	 *
	 * @param array $args array of global theme values.
	 * @param array $instance array of widget form values.
	 * @uses  katb_allowed_html() for allowed tags from /includes/katb_functions.php
	 */
	public function widget( $args, $instance ) {
		// Get user options.
		global $katb_options;
		$use_gdpr                       = $katb_options['katb_use_gdpr'];
		$gdpr_note                      = $katb_options['katb_gdpr_save_data_note'];
		$include_widget_email_note      = $katb_options['katb_include_widget_email_note'];
		$widget_email_note              = $katb_options['katb_widget_email_note'];
		$author_label_widget            = $katb_options['katb_widget_author_label'];
		$email_label_widget             = $katb_options['katb_widget_email_label'];
		$website_label_widget           = $katb_options['katb_widget_website_label'];
		$location_label_widget          = $katb_options['katb_widget_location_label'];
		$custom1_label_widget           = $katb_options['katb_widget_custom1_label'];
		$custom2_label_widget           = $katb_options['katb_widget_custom2_label'];
		$testimonial_title_label_widget = $katb_options['katb_widget_testimonial_title_label'];
		$rating_label_widget            = $katb_options['katb_widget_rating_label'];
		$testimonial_label_widget       = $katb_options['katb_widget_testimonial_label'];
		$widget_captcha_label           = $katb_options['katb_widget_captcha_label'];
		$submit_label_widget            = $katb_options['katb_widget_submit_label'];
		$reset_label_widget             = $katb_options['katb_widget_reset_label'];
		$exclude_website                = $katb_options['katb_exclude_website_input'];
		$require_website                = $katb_options['katb_require_website_input'];
		$exclude_location               = $katb_options['katb_exclude_location_input'];
		$require_location               = $katb_options['katb_require_location_input'];
		$exclude_custom1                = $katb_options['katb_exclude_custom1_input'];
		$require_custom1                = $katb_options['katb_require_custom1_input'];
		$exclude_custom2                = $katb_options['katb_exclude_custom2_input'];
		$require_custom2                = $katb_options['katb_require_custom2_input'];
		$exclude_testimonial_title      = $katb_options['katb_exclude_testimonial_title_input'];
		$require_testimonial_title      = $katb_options['katb_require_testimonial_title_input'];
		$use_ratings                    = $katb_options['katb_use_ratings'];
		$auto_approve                   = $katb_options['katb_auto_approve'];
		$use_widget_popup               = $katb_options['katb_use_widget_popup_message'];
		$labels_above                   = $katb_options['katb_widget_labels_above'];
		$widget_required_label          = $katb_options['katb_widget_required_label'];
		$katb_widget_rating             = '0.0';
		// Get the widget title and display.
		echo wp_kses_post( $args['before_widget'] );
		$title = apply_filters( 'widget_title', empty( $instance['katb_input_widget_title'] ) ? '' : $instance['katb_input_widget_title'], $instance, $this->id_base );
		if ( ! empty( $title ) ) {
			echo wp_kses_post( $args['before_title'] ) . wp_kses_post( $title ) . wp_kses_post( $args['after_title'] );
		}
		// Set up database table name for use later.
		global $wpdb, $tablename;
		$tablename = $wpdb->prefix . 'testimonial_basics';
		// Initialize Variables.
		if ( false === $labels_above ) {
			$katb_widget_author            = $author_label_widget;
			$katb_widget_email             = $email_label_widget;
			$katb_widget_website           = $website_label_widget;
			$katb_widget_location          = $location_label_widget;
			$katb_widget_custom1           = $custom1_label_widget;
			$katb_widget_custom2           = $custom2_label_widget;
			$katb_widget_testimonial_title = $testimonial_title_label_widget;
			$katb_widget_testimonial       = $testimonial_label_widget;
		} else {
			$katb_widget_author            = '';
			$katb_widget_email             = '';
			$katb_widget_website           = '';
			$katb_widget_location          = '';
			$katb_widget_custom1           = '';
			$katb_widget_custom2           = '';
			$katb_widget_testimonial_title = '';
			$katb_widget_testimonial       = '';
		}
		$gdpr_approved           = false;
		$katb_allowed_html       = katb_allowed_html();
		$katb_widget_input_group = esc_attr( $instance['katb_input_widget_group'] );
		if ( '' === $katb_widget_input_group ) {
			$katb_widget_input_group = 'All';
		}
		$katb_widget_input_form_no = sanitize_text_field( $instance['katb_input_widget_form_no'] );
		if ( '' === $katb_widget_input_form_no ) {
			$katb_widget_input_form_no = '1';
		}
		$post_name  = 'widget_submitted' . $katb_widget_input_form_no;
		$reset_name = 'widget_reset' . $katb_widget_input_form_no;
		// Process input form.
		if ( isset( $_POST[ $post_name ], $_POST[ 'katb_widget_form_nonce' . $katb_widget_input_form_no ] ) // Input var okay.
			&& wp_verify_nonce( sanitize_key( $_POST[ 'katb_widget_form_nonce' . $katb_widget_input_form_no ] ), 'katb_nonce_2' ) ) { // Input var okay.
			// Check for valid submission.
			$katb_bot_submission = false;
			if ( true === $katb_options['katb_use_honeypot'] ) {
				if ( ! empty( $_POST['tb_widget_custom3'] ) ) { // Input var okay.
					$katb_bot_submission = true;
				}
			}
			// Proceed if a human submission.
			if ( false === $katb_bot_submission ) {
				// Initialize error string.
				$katb_widget_html_error  = '';
				$katb_widget_popup_error = '';
				// Set default variables.
				$katb_widget_order = 0;
				if ( true === $auto_approve ) {
					$katb_widget_approved = 1;
				} else {
					$katb_widget_approved = 0;
				}
				$katb_widget_datetime = current_time( 'mysql' );
				// validate GDPR.
				if ( true === $use_gdpr ) {
					if ( isset( $_POST['tb_gdpr'] ) ) { // Input var okay.
						$gdpr_approved = true;
					} else {
						$gdpr_approved = false;
						if ( true === $use_widget_popup ) {
							$katb_widget_popup_error .= '\n - ' . esc_html__( 'You must check the box to allow us to save the testimonial data', 'testimonial-basics' );
						} else {
							$katb_widget_html_error .= '<br/> - ' . esc_html__( 'You must check the box to allow us to save the testimonial data', 'testimonial-basics' );
						}
					}
				}
				// Validate author.
				if ( ! empty( $_POST['tb_author'] ) ) { // Input var okay.
					$katb_widget_author = sanitize_text_field( wp_unslash( $_POST['tb_author'] ) ); // Input var okay.
				} else {
					$katb_widget_author = '';
				}
				if ( $katb_widget_author === $author_label_widget || '' === $katb_widget_author ) {
					if ( true === $use_widget_popup ) {
						$katb_widget_popup_error .= '\n - ' . esc_html__( 'Author required', 'testimonial-basics' );
					} else {
						$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Author required', 'testimonial-basics' );
					}
					if ( true === $labels_above ) {
						$katb_widget_author = '';
					} else {
						$katb_widget_author = $author_label_widget;
					}
				}
				// Validate email.
				if ( ! empty( $_POST['tb_email'] ) ) { // Input var okay.
					$katb_widget_email = sanitize_email( wp_unslash( $_POST['tb_email'] ) ); // Input var okay.
				} else {
					$katb_widget_email = '';
				}
				if ( ! is_email( $katb_widget_email ) ) {
					if ( true === $use_widget_popup ) {
						$katb_widget_popup_error .= '\n - ' . esc_html__( 'Valid email required ', 'testimonial-basics' );
					} else {
						$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Valid email required ', 'testimonial-basics' );
					}
					if ( true === $labels_above ) {
						$katb_widget_email = '';
					} else {
						$katb_widget_email = $email_label_widget;
					}
				}
				// validate website.
				if ( false === $exclude_website ) {
					if ( ! empty( $_POST['tb_website'] ) ) { // Input var okay.
						$katb_widget_website = esc_url_raw( wp_unslash( $_POST['tb_website'] ) ); // Input var okay.
					} else {
						$katb_widget_website = '';
					}
					if ( '' === $katb_widget_website || true === strpos( $katb_widget_website, $website_label_widget ) ) {
						if ( true === $require_website ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . esc_html__( 'Website required ', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Website required ', 'testimonial-basics' );
							}
						}
						if ( true === $labels_above ) {
							$katb_widget_website = '';
						} else {
							$katb_widget_website = $website_label_widget;
						}
					}
				} else {
					$katb_widget_website = '';
				}
				// Validate location.
				if ( false === $exclude_location ) {
					if ( ! empty( $_POST['tb_location'] ) ) { // Input var okay.
						$katb_widget_location = sanitize_text_field( wp_unslash( $_POST['tb_location'] ) ); // Input var okay.
					} else {
						$katb_widget_location = '';
					}
					if ( '' === $katb_widget_location || $katb_widget_location === $location_label_widget ) {
						if ( true === $require_location ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . esc_html__( 'Location required ', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Location required ', 'testimonial-basics' );
							}
						}
						if ( true === $labels_above ) {
							$katb_widget_location = '';
						} else {
							$katb_widget_location = $location_label_widget;
						}
					}
				} else {
					$katb_widget_location = '';
				}
				// Validate custom1.
				if ( false === $exclude_custom1 ) {
					if ( ! empty( $_POST['tb_custom1'] ) ) { // Input var okay.
						$katb_widget_custom1 = sanitize_text_field( wp_unslash( $_POST['tb_custom1'] ) ); // Input var okay.
					} else {
						$katb_widget_custom1 = '';
					}
					if ( '' === $katb_widget_custom1 || $katb_widget_custom1 === $custom1_label_widget ) {
						if ( true === $require_custom1 ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . $custom1_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . $custom1_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							}
						}
						if ( true === $labels_above ) {
							$katb_widget_custom1 = '';
						} else {
							$katb_widget_custom1 = $custom1_label_widget;
						}
					}
				} else {
					$katb_widget_custom1 = '';
				}
				// Validate custom2.
				if ( false === $exclude_custom2 ) {
					if ( ! empty( $_POST['tb_custom2'] ) ) { // Input var okay.
						$katb_widget_custom2 = sanitize_text_field( wp_unslash( $_POST['tb_custom2'] ) ); // Input var okay.
					} else {
						$katb_widget_custom2 = '';
					}
					if ( '' === $katb_widget_custom2 || $katb_widget_custom2 === $custom2_label_widget ) {
						if ( true === $require_custom2 ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . $custom2_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . $custom2_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							}
						}
						if ( true === $labels_above ) {
							$katb_widget_custom2 = '';
						} else {
							$katb_widget_custom2 = $custom2_label_widget;
						}
					}
				} else {
					$katb_widget_custom2 = '';
				}
				// Validate rating.
				if ( true === $use_ratings ) {
					if ( ! empty( $_POST['tb_rating_widget'] ) ) { // Input var okay.
						$katb_widget_rating = sanitize_text_field( wp_unslash( $_POST['tb_rating_widget'] ) ); // Input var okay.
					} else {
						$katb_widget_rating = '0.0';
					}
					if ( '' === $katb_widget_rating ) {
						$katb_widget_rating = '0.0';
					}
					if ( '1' === $katb_widget_rating ) {
						$katb_widget_rating = '1.0';
					}
					if ( '2' === $katb_widget_rating ) {
						$katb_widget_rating = '2.0';
					}
					if ( '3' === $katb_widget_rating ) {
						$katb_widget_rating = '3.0';
					}
					if ( '4' === $katb_widget_rating ) {
						$katb_widget_rating = '4.0';
					}
					if ( '5' === $katb_widget_rating ) {
						$katb_widget_rating = '5.0';
					}
					if ( '0' === $katb_widget_rating ) {
						$katb_widget_rating = '0.0';
					}
				} else {
					$katb_widget_rating = '0.0';
				}
				// Captcha Check.
				if ( true === $katb_options['katb_use_captcha'] ) {
					if ( true === $katb_options['katb_use_recaptcha'] ) {
						if ( ! empty( $_POST['g-recaptcha-response'] ) ) { // Input var okay.
							$captcha_response = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ); // Input var okay.
						} else {
							$captcha_response = false;
						}
						if ( false === $captcha_response ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . esc_html__( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Please show you are a human and check the captcha box', 'testimonial-basics' );
							}
						} else {
							$secret_key      = esc_html( $katb_options['katb_secret_key'] );
							$request         = wp_safe_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $captcha_response );
							$verify_response = wp_remote_retrieve_body( $request );
							$response_data   = json_decode( $verify_response );
							if ( false === $response_data->success ) {
								if ( true === $use_widget_popup ) {
									$katb_widget_popup_error .= '\n - ' . esc_html__( 'Captcha failed - please try again', 'testimonial-basics' );
								} else {
									$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Captcha failed - please try again', 'testimonial-basics' );
								}
							}
						}
					} else {
						if ( ! empty( $_POST['verify'] ) ) { // Input var okay.
							$katb_captcha_entered = sanitize_text_field( wp_unslash( $_POST['verify'] ) ); // Input var okay.
						} else {
							$katb_captcha_entered = '';
						}
						if ( get_transient( 'katb_pass_phrase_widget' . $katb_widget_input_form_no ) !== sha1( $katb_captcha_entered ) ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . esc_html__( 'Captcha is invalid - please try again', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Captcha is invalid - please try again', 'testimonial-basics' );
							}
						}
					}
				}
				// Validate testimonial_title.
				if ( false === $exclude_testimonial_title ) {
					if ( ! empty( $_POST['tb_title'] ) ) { // Input var okay.
						$katb_widget_testimonial_title = sanitize_text_field( wp_unslash( $_POST['tb_title'] ) ); // Input var okay.
					} else {
						$katb_widget_testimonial_title = '';
					}
					if ( '' === $katb_widget_testimonial_title || $katb_widget_testimonial_title === $testimonial_title_label_widget ) {
						if ( true === $require_testimonial_title ) {
							if ( true === $use_widget_popup ) {
								$katb_widget_popup_error .= '\n - ' . $testimonial_title_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							} else {
								$katb_widget_html_error .= '<br/> - ' . $testimonial_title_label_widget . ' ' . esc_html__( 'required ', 'testimonial-basics' );
							}
						}
						if ( true === $labels_above ) {
							$katb_widget_testimonial_title = '';
						} else {
							$katb_widget_testimonial_title = $testimonial_title_label_widget;
						}
					}
				} else {
					$katb_widget_testimonial_title = '';
				}
				// Validate Testimonial.
				// Check for error before processing to avoid html encoding until all is good.
				// Premature encoding causes wp_kses to remove smiley images on second pass.
				if ( '' === $katb_widget_html_error && '' !== $katb_widget_popup_error ) {
					// Sanitize first.
					if ( ! empty( $_POST['tb_testimonial'] ) ) { // Input var okay.
						$katb_sanitize_testimonial = wp_kses( wp_unslash( $_POST['tb_testimonial'] ), $katb_allowed_html ); // Input var okay.
						// Add WordPress Smiley support.
						$katb_fix_emoticons = convert_smilies( $katb_sanitize_testimonial );
						// If emoji present convert to html entities.
						$katb_widget_testimonial = wp_encode_emoji( $katb_fix_emoticons );
					} else {
						$katb_widget_testimonial = '';
					}
				} else {
					$katb_widget_testimonial = wp_kses( wp_unslash( $_POST['tb_testimonial'] ), $katb_allowed_html ); // Input var okay.
				}
				if ( $katb_widget_testimonial === $testimonial_label_widget || '' === $katb_widget_testimonial ) {
					if ( true === $use_widget_popup ) {
						$katb_widget_popup_error .= '\n - ' . esc_html__( 'Testimonial required', 'testimonial-basics' );
					} else {
						$katb_widget_html_error .= '<br/> - ' . esc_html__( 'Testimonial required', 'testimonial-basics' );
					}
					if ( true !== $labels_above ) {
						$katb_widget_testimonial = $testimonial_label_widget;
					} else {
						$katb_widget_testimonial = '';
					}
				}
				// Validation complete.
				if ( '' === $katb_widget_html_error && '' === $katb_widget_popup_error ) {
					if ( $katb_widget_website === $website_label_widget ) {
						$katb_widget_website = '';
					}
					if ( $katb_widget_location === $location_label_widget ) {
						$katb_widget_location = '';
					}
					// OK $error is empty so let's update the database.
					$values         = array(
						'tb_date'        => $katb_widget_datetime,
						'tb_order'       => $katb_widget_order,
						'tb_approved'    => $katb_widget_approved,
						'tb_group'       => $katb_widget_input_group,
						'tb_name'        => $katb_widget_author,
						'tb_email'       => $katb_widget_email,
						'tb_location'    => $katb_widget_location,
						'tb_custom1'     => $katb_widget_custom1,
						'tb_custom2'     => $katb_widget_custom2,
						'tb_url'         => $katb_widget_website,
						'tb_pic_url'     => '',
						'tb_rating'      => $katb_widget_rating,
						'tb_title'       => $katb_widget_testimonial_title,
						'tb_testimonial' => $katb_widget_testimonial,
					);
					$formats_values = array( '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
					$wpdb->insert( $tablename, $values, $formats_values ); // WPCS: db call ok.
					// Send notification email.
					katb_email_notification( $katb_widget_author, $katb_widget_email, $katb_widget_testimonial );
					// Optional supmitted popup message.
					if ( true === $use_widget_popup ) {
						?>
						<script type="text/javascript"><?php echo 'alert( "' . esc_html__( 'Testimonial Submitted - Thank You!', 'testimonial-basics' ) . '" )'; ?></script>
						<?php
					} else {
							echo '<div class="katb_widget_sent">' . esc_html__( 'Testimonial Submitted - Thank You!', 'testimonial-basics' ) . '</div>';
					}
					// Initialize Variables.
					if ( false === $labels_above ) {
						$katb_widget_author            = $author_label_widget;
						$katb_widget_email             = $email_label_widget;
						$katb_widget_website           = $website_label_widget;
						$katb_widget_location          = $location_label_widget;
						$katb_widget_custom1           = $custom1_label_widget;
						$katb_widget_custom2           = $custom2_label_widget;
						$katb_widget_testimonial_title = $testimonial_title_label_widget;
						$katb_widget_testimonial       = $testimonial_label_widget;
					} else {
						$katb_widget_author            = '';
						$katb_widget_email             = '';
						$katb_widget_website           = '';
						$katb_widget_location          = '';
						$katb_widget_custom1           = '';
						$katb_widget_custom2           = '';
						$katb_widget_testimonial_title = '';
						$katb_widget_testimonial       = '';
					}
					$katb_widget_rating = '0.0';
				} else {
					if ( true === $use_widget_popup ) {
						$widget_error_message = esc_html__( 'There were errors so the testimonial was not added: ', 'testimonial-basics' ) . '\n' . $katb_widget_popup_error;
						?>
						<script>alert("<?php echo $widget_error_message; // phpcs:ignore ?>")</script>
						<?php
					} else {
							echo '<div class="katb_widget_error">' . esc_html__( 'There were errors so the testimonial was not added: ', 'testimonial-basics' ) . $katb_widget_html_error . '</div>'; // phpcs:ignore
					}
				}
			}
		}
		// Reset button is clicked.
		if ( isset( $_POST[ $reset_name ] ) ) { // Input var okay.
			// Initialize Variables.
			if ( false === $labels_above ) {
				$katb_widget_author            = $author_label_widget;
				$katb_widget_email             = $email_label_widget;
				$katb_widget_website           = $website_label_widget;
				$katb_widget_location          = $location_label_widget;
				$katb_widget_custom1           = $custom1_label_widget;
				$katb_widget_custom2           = $custom2_label_widget;
				$katb_widget_testimonial_title = $testimonial_title_label_widget;
				$katb_widget_testimonial       = $testimonial_label_widget;
			} else {
				$katb_widget_author            = '';
				$katb_widget_email             = '';
				$katb_widget_website           = '';
				$katb_widget_location          = '';
				$katb_widget_custom1           = '';
				$katb_widget_custom2           = '';
				$katb_widget_testimonial_title = '';
				$katb_widget_testimonial       = '';
			}
		}
		?>
		<div class="katb_widget_form">
			<?php
			if ( true === $include_widget_email_note ) {
				?>
				<p><?php echo esc_html( stripslashes( $widget_email_note ) ); ?></p>
				<?php
			}
			?>
			<form method="POST">
				<?php
				wp_nonce_field( 'katb_nonce_2', 'katb_widget_form_nonce' . $katb_widget_input_form_no );
				// GDPR approval.
				if ( true === $use_gdpr ) {
					?>
					<span class="widget-gdpr-approve">
						<input class="widget-gdpr-checkbox" type="checkbox" name="tb_gdpr" id="gdpr_checkbox-id" <?php checked( $gdpr_approved, true ); ?>>
						<span class="widget-gdpr-label">
							<?php echo esc_html( $gdpr_note ); ?>
						</span>
					</span>
					<?php
				}
				// Author.
				if ( true === $labels_above ) {
					?>
					<label class="katb_widget_input_label">
						<?php echo esc_html( $author_label_widget ); ?>
					</label>
					<?php
				}
				if ( $katb_widget_author === $author_label_widget || '' === $katb_widget_author ) {
					?>
					<input class="katb_input" type="text" name="tb_author" placeholder="<?php echo esc_attr( $katb_widget_author ); ?>" />
					<?php
				} else {
					?>
					<input class="katb_input" type="text" name="tb_author" value="<?php echo esc_attr( $katb_widget_author ); ?>" />
					<?php
				}
				// Email.
				if ( true === $labels_above ) {
					?>
					<label class="katb_widget_input_label">
						<?php echo esc_html( $email_label_widget ); ?>
					</label>
					<?php
				}
				if ( $katb_widget_email === $email_label_widget || '' === $katb_widget_email ) {
					?>
					<input class="katb_input" type="text" name="tb_email" placeholder="<?php echo esc_attr( $katb_widget_email ); ?>" />
					<?php
				} else {
					?>
					<input class="katb_input" type="text" name="tb_email" value="<?php echo esc_attr( $katb_widget_email ); ?>" />
					<?php
				}
				// Website.
				if ( false === $exclude_website ) {
					if ( true === $labels_above ) {
						?>
						<label class="katb_widget_input_label">
							<?php echo esc_html( $website_label_widget ); ?>
						</label>
						<?php
					}
					if ( $katb_widget_website === $website_label_widget || '' === $katb_widget_website ) {
						?>
						<input class="katb_input" type="text" name="tb_website" placeholder="<?php echo esc_attr( $katb_widget_website ); ?>" />
						<?php
					} else {
						?>
						<input class="katb_input" type="text" name="tb_website" value="<?php echo esc_url( $katb_widget_website ); ?>" />
						<?php
					}
				}
				// Location.
				if ( true !== $exclude_location ) {
					if ( true === $labels_above ) {
						?>
						<label class="katb-widget-input-label">
							<?php echo esc_html( $location_label_widget ); ?>
						</label>
						<?php
					}
					if ( $katb_widget_location === $location_label_widget || '' === $katb_widget_location ) {
						?>
						<input class="katb_input" type="text" name="tb_location" placeholder="<?php echo esc_attr( $katb_widget_location ); ?>" />
						<?php
					} else {
						?>
						<input class="katb_input" type="text" name="tb_location" value="<?php echo esc_attr( $katb_widget_location ); ?>" />
						<?php
					}
				}
				// Custom 1.
				if ( true !== $exclude_custom1 ) {
					if ( true === $labels_above ) {
						?>
						<label class="katb-widget-input-label">
							<?php echo esc_html( $custom1_label_widget ); ?>
						</label>
						<?php
					}
					if ( $katb_widget_custom1 === $custom1_label_widget || '' === $katb_widget_custom1 ) {
						?>
						<input class="katb_input" type="text" name="tb_custom1" placeholder="<?php echo esc_attr( $katb_widget_custom1 ); ?>" />
						<?php
					} else {
						?>
						<input class="katb_input" type="text" name="tb_custom1" value="<?php echo esc_attr( $katb_widget_custom1 ); ?>" />
						<?php
					}
				}
				// Custom 2.
				if ( true !== $exclude_custom2 ) {
					if ( true === $labels_above ) {
						?>
						<label class="katb-widget-input-label">
							<?php echo esc_html( $custom2_label_widget ); ?>
						</label>
						<?php
					}
					if ( $katb_widget_custom2 === $custom2_label_widget || '' === $katb_widget_custom2 ) {
						?>
						<input class="katb_input" type="text" name="tb_custom2" placeholder="<?php echo esc_attr( $katb_widget_custom2 ); ?>" />
						<?php
					} else {
						?>
						<input class="katb_input" type="text" name="tb_custom2" value="<?php echo esc_attr( $katb_widget_custom2 ); ?>" />
						<?php
					}
				}
				// Ratings.
				if ( true === $use_ratings ) {
					?>
					<label class="katb_widget_input_label"><?php echo esc_html( $rating_label_widget ); ?></label>
					<select name="tb_rating_widget" class="katb_css_rating_select_widget">
						<option <?php selected( esc_attr( $katb_widget_rating ) ); ?> value="<?php echo esc_attr( $katb_widget_rating ); ?>"><?php echo esc_html( $katb_widget_rating ); ?></option>
						<option value="0.0" <?php selected( esc_attr( $katb_widget_rating ), '0.0' ); ?>>0.0</option>
						<option value="0.5" <?php selected( esc_attr( $katb_widget_rating ), '0.5' ); ?>>0.5</option>
						<option value="1.0" <?php selected( esc_attr( $katb_widget_rating ), '1.0' ); ?>>1.0</option>
						<option value="1.5" <?php selected( esc_attr( $katb_widget_rating ), '1.5' ); ?>>1.5</option>
						<option value="2.0" <?php selected( esc_attr( $katb_widget_rating ), '2.0' ); ?>>2.0</option>
						<option value="2.5" <?php selected( esc_attr( $katb_widget_rating ), '2.5' ); ?>>2.5</option>
						<option value="3.0" <?php selected( esc_attr( $katb_widget_rating ), '3.0' ); ?>>3.0</option>
						<option value="3.5" <?php selected( esc_attr( $katb_widget_rating ), '3.5' ); ?>>3.5</option>
						<option value="4.0" <?php selected( esc_attr( $katb_widget_rating ), '4.0' ); ?>>4.0</option>
						<option value="4.5" <?php selected( esc_attr( $katb_widget_rating ), '4.5' ); ?>>4.5</option>
						<option value="5.0" <?php selected( esc_attr( $katb_widget_rating ), '5.0' ); ?>>5.0</option>
					</select>
					<?php
				}
				// Testimonial Title.
				if ( false === $exclude_testimonial_title ) {
					if ( true === $labels_above ) {
						?>
						<label class="katb_widget_input_label">
							<?php echo esc_html( $testimonial_title_label_widget ); ?>
						</label>
						<?php
					}
					if ( $katb_widget_testimonial_title === $testimonial_title_label_widget || '' === $katb_widget_testimonial_title ) {
						?>
						<input class="katb_input" type="text" name="tb_title" placeholder="<?php echo esc_attr( $katb_widget_testimonial_title ); ?>" />
						<?php
					} else {
						?>
						<input class="katb_input" type="text" name="tb_title" value="<?php echo esc_attr( $katb_widget_testimonial_title ); ?>" />
						<?php
					}
				}
				// Testimonial.
				if ( true === $labels_above ) {
					?>
					<br/><label class="katb_widget_input_label">
						<?php echo esc_html( $testimonial_label_widget ); ?>
					</label>
					<?php
				}
				if ( $katb_widget_testimonial === $testimonial_label_widget || '' === $katb_widget_testimonial ) {
					?>
					<textarea class="katb-widget-input-textarea" name="tb_testimonial" rows="5" placeholder="<?php echo wp_kses_post( $katb_widget_testimonial ); ?>"></textarea>
					<?php
				} else {
					?>
					<textarea class="katb-widget-input-textarea" name="tb_testimonial" rows="5" ><?php echo wp_kses_post( $katb_widget_testimonial ); ?></textarea>
					<?php
				}
				// Show HTML strip.
				if ( true === $katb_options['katb_show_html_widget'] ) {
					?>
					<p>HTML: <code>a p br i em strong q h1-h6</code></p><?php // translate ok. ?>
					<?php
				}
				// Captcha.
				if ( true === $katb_options['katb_use_captcha'] ) {
					?>
					<div class="katb_widget_captcha">
						<?php
						if ( true === $katb_options['katb_use_recaptcha'] ) {
							$site_key = $katb_options['katb_site_key'];
							?>
							<div id="widget_captcha_<?php echo esc_attr( $katb_widget_input_form_no ); ?>"
								class="g-recaptcha"
								data-captchaid="katb_widget_captchaid_<?php echo esc_attr( $katb_widget_input_form_no ); ?>"
								data-sitekey="<?php echo esc_attr( $site_key ); ?>">
							</div>
							<?php
						} elseif ( true === $katb_options['katb_use_color_captcha_2'] ) {
							echo katb_color_captcha_2( 'widget', $katb_widget_input_form_no ); // phpcs:ignore
							?>
							<input class="katb_captcha_widget_input"
									type="text"
									id="verify_widget_<?php echo esc_attr( $katb_widget_input_form_no ); ?>"
									name="verify"
									value="<?php echo esc_attr( $widget_captcha_label ); ?>"
									onclick="this.select();" /><br/>
							<?php
						} elseif ( true === $katb_options['katb_use_color_captcha'] ) {
							echo katb_color_captcha( 'widget', $katb_widget_input_form_no ); // phpcs:ignore
							?>
							<input class="katb_captcha_widget_input"
									type="text"
									id="verify_widget_<?php echo esc_attr( $katb_widget_input_form_no ); ?>"
									name="verify"
									value="<?php echo esc_attr( $widget_captcha_label ); ?>"
									onclick="this.select();" /><br/>
							<?php
						} else {
							echo katb_bw_captcha( 'widget', $katb_widget_input_form_no ); // phpcs:ignore
							?>
							<input class="katb_captcha_widget_input"
									type="text"
									id="verify_widget_<?php echo esc_attr( $katb_widget_input_form_no ); ?>"
									name="verify"
									value="<?php echo esc_attr( $widget_captcha_label ); ?>"
									onclick="this.select();" /><br/>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				<input class="katb_widget_submit" type="submit" name="<?php echo esc_attr( $post_name ); ?>" value="<?php echo esc_attr( $submit_label_widget ); ?>" />
				<input class="katb_widget_reset" type="submit" name="<?php echo esc_attr( $reset_name ); ?>" value="<?php echo esc_attr( $reset_label_widget ); ?>" />
					<?php
					if ( true === $katb_options['katb_use_honeypot'] ) {
						?>
						<span class="katb_span_custom3"><?php esc_html_e( 'This input should not be filled out', 'testimonial-basics' ); ?>
							<input class="custom_3" type="text" maxlength="100" name="tb_widget_custom3" value="" tabindex="-1" autocomplete="off" />
						</span>
						<?php
					}
					?>
			</form>
			<?php
			if ( '' !== $widget_required_label ) {
				?>
				<div class="katb_clear_fix"></div>
				<p><?php echo esc_html( $widget_required_label ); ?></p>
				<?php
			}
			?>
			<div class="katb_clear_fix"></div>
			<?php
			if ( true === $katb_options['katb_show_widget_gravatar_link'] ) {
				?>
				<span class="katb_use_gravatar_wrap">
					<span class="use_gravatar"><?php esc_html_e( 'Add a Photo? ', 'testimonial-basics' ); ?></span>
					<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >
						<img class="gravatar_logo" src="<?php echo plugins_url();// phpcs:ignore ?>/testimonial-basics/includes/Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />
					</a>
				</span>
				<?php
			}
			?>
			</div>
			<br style="clear:both;" />
			<?php
			echo wp_kses_post( $args['after_widget'] );
	}
}
