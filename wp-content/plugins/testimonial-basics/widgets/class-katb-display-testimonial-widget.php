<?php
/**
 * Plugin Name: Testimonial Basics Display Widget
 * Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
 * Description: A plugin to display testimonials in a widget
 * Version: 4.5.1
 * Author: Kevin Archibald
 * Author URI: http://kevinsspace.ca/
 * License: GPLv3
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/**
 * Use widgets_init action hook to execute custom function.
 */
add_action( 'widgets_init', 'katb_display_register_widget' );
/**
 * Register our widget.
 */
function katb_display_register_widget() {
	register_widget( 'katb_display_testimonial_widget' );
}
/**
 * Widget class.
 */
class KATB_Display_Testimonial_Widget extends WP_Widget {
	/**
	 * Process the new widget.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'katb_display_widget_class',
			'description' => __( 'Display Testimonials.', 'testimonial-basics' ),
		);
		parent::__construct( 'katb_display_testimonial_widget', __( 'Testimonial Display Widget', 'testimonial-basics' ), $widget_ops );
	}
	/**
	 * Form for widget setup.
	 *
	 * @param array $instance is an array of parameters for widget.
	 */
	public function form( $instance ) {
		$katb_display_defaults = array(
			'katb_display_widget_title'           => 'Testimonials',
			'katb_display_widget_group'           => 'all',
			'katb_display_widget_number'          => 'all',
			'katb_display_widget_by'              => 'date',
			'katb_display_widget_ids'             => '',
			'katb_display_widget_rotate'          => 'no',
			'katb_display_widget_layout_override' => '',
			'katb_display_widget_schema_override' => 'default',
		);
		$instance              = wp_parse_args( (array) $instance, $katb_display_defaults );
		$title                 = $instance['katb_display_widget_title'];
		$group                 = $instance['katb_display_widget_group'];
		$number                = $instance['katb_display_widget_number'];
		$by                    = $instance['katb_display_widget_by'];
		$ids                   = $instance['katb_display_widget_ids'];
		$rotate                = $instance['katb_display_widget_rotate'];
		$layout_override       = $instance['katb_display_widget_layout_override'];
		$use_schema_override   = $instance['katb_display_widget_schema_override'];
		?>
		<p>
			<?php esc_html_e( 'Title : ', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_display_widget_title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_title' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Group : ', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_display_widget_group' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_group' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $group ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Number : ', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_display_widget_number' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_number' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'By : ', 'testimonial-basics' ); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_by' ) ); ?>">
				<option value="date" <?php selected( $by, 'date' ); ?>>date</option>
				<option value="order" <?php selected( $by, 'order' ); ?>>order</option>
				<option value="random" <?php selected( $by, 'random' ); ?>>random</option>
			</select>
		</p>
		<p>
			<?php esc_html_e( 'IDs : ', 'testimonial-basics' ); ?>
			<input class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'katb_display_widget_ids' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_ids' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $ids ); ?>" />
		</p>
		<p><?php esc_html_e( 'Rotate : ', 'testimonial-basics' ); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_rotate' ) ); ?>">
				<option value="no" <?php selected( $rotate, 'no' ); ?>>no</option>
				<option value="yes" <?php selected( $rotate, 'yes' ); ?>>yes</option>
			</select>
		</p>
		<p><?php esc_html_e( 'Layout : ', 'testimonial-basics' ); ?><br/>
			<select style="font-size:12px;" name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_layout_override' ) ); ?>">
				<option value="0" <?php selected( $layout_override, '0' ); ?>><?php esc_html_e( 'default', 'testimonial-basics' ); ?></option>
				<option value="1" <?php selected( $layout_override, '1' ); ?>><?php esc_html_e( 'no format-meta top', 'testimonial-basics' ); ?></option>
				<option value="2" <?php selected( $layout_override, '2' ); ?>><?php esc_html_e( 'no format-meta bottom', 'testimonial-basics' ); ?></option>
				<option value="3" <?php selected( $layout_override, '3' ); ?>><?php esc_html_e( 'no format-image meta top', 'testimonial-basics' ); ?></option>
				<option value="4" <?php selected( $layout_override, '4' ); ?>><?php esc_html_e( 'no format-image meta bottom', 'testimonial-basics' ); ?></option>
				<option value="5" <?php selected( $layout_override, '5' ); ?>><?php esc_html_e( 'no format-centered image meta top', 'testimonial-basics' ); ?></option>
				<option value="6" <?php selected( $layout_override, '6' ); ?>><?php esc_html_e( 'no format-centered image meta bottom', 'testimonial-basics' ); ?></option>
				<option value="7" <?php selected( $layout_override, '7' ); ?>><?php esc_html_e( 'format-meta top', 'testimonial-basics' ); ?></option>
				<option value="8" <?php selected( $layout_override, '8' ); ?>><?php esc_html_e( 'format-meta bottom', 'testimonial-basics' ); ?></option>
				<option value="9" <?php selected( $layout_override, '9' ); ?>><?php esc_html_e( 'format-image meta top', 'testimonial-basics' ); ?></option>
				<option value="10" <?php selected( $layout_override, '10' ); ?>><?php esc_html_e( 'format-image meta bottom', 'testimonial-basics' ); ?></option>
				<option value="11" <?php selected( $layout_override, '11' ); ?>><?php esc_html_e( 'format-centered image meta top', 'testimonial-basics' ); ?></option>
				<option value="12" <?php selected( $layout_override, '12' ); ?>><?php esc_html_e( 'format-centered image meta bottom', 'testimonial-basics' ); ?></option>
			</select>
		</p>
		<p><?php esc_html_e( 'Use Schema : ', 'testimonial-basics' ); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_schema_override' ) ); ?>">
				<option value="default" <?php selected( $use_schema_override, 'yes' ); ?>><?php esc_html_e( 'use default', 'testimonial-basics' ); ?></option>
				<option value="no" <?php selected( $use_schema_override, 'no' ); ?>><?php esc_html_e( 'no', 'testimonial-basics' ); ?></option>
				<option value="yes" <?php selected( $use_schema_override, 'yes' ); ?>><?php esc_html_e( 'yes', 'testimonial-basics' ); ?></option>
			</select>
		</p>
		<?php
	}
	/**
	 * Save the widget settings.
	 *
	 * @param array $new_instance is array of new instance data.
	 * @param array $old_instance is array of old instance data.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                                        = $old_instance;
		$instance['katb_display_widget_title']           = sanitize_text_field( $new_instance['katb_display_widget_title'] );
		$instance['katb_display_widget_group']           = sanitize_text_field( $new_instance['katb_display_widget_group'] );
		$instance['katb_display_widget_number']          = sanitize_text_field( $new_instance['katb_display_widget_number'] );
		$instance['katb_display_widget_by']              = strtolower( sanitize_text_field( $new_instance['katb_display_widget_by'] ) );
		$instance['katb_display_widget_ids']             = sanitize_text_field( $new_instance['katb_display_widget_ids'] );
		$instance['katb_display_widget_rotate']          = strtolower( sanitize_text_field( $new_instance['katb_display_widget_rotate'] ) );
		$instance['katb_display_widget_layout_override'] = sanitize_text_field( $new_instance['katb_display_widget_layout_override'] );
		$instance['katb_display_widget_schema_override'] = sanitize_text_field( $new_instance['katb_display_widget_schema_override'] );
		// Rotate flag whitelist.
		if ( 'yes' !== $instance['katb_display_widget_rotate'] ) {
			$instance['katb_display_widget_rotate'] = 'no';
		}
		// Group validation/whitelist.
		if ( '' === $instance['katb_display_widget_group'] || 'All' === $instance['katb_display_widget_group'] ) {
			$instance['katb_display_widget_group'] = 'all';
		}
		// Number validation/whitelist.
		if ( '' === $instance['katb_display_widget_number'] ) {
			$instance['katb_display_widget_number'] = 'all';
		}
		if ( 'all' !== $instance['katb_display_widget_number'] ) {
			if ( intval( $instance['katb_display_widget_number'] ) < 1 ) {
				$instance['katb_display_widget_number'] = 1;
			} else {
				$instance['katb_display_widget_number'] = intval( $instance['katb_display_widget_number'] );
			}
		}
		// By whitelist.
		if ( 'date' !== $instance['katb_display_widget_by'] && 'order' !== $instance['katb_display_widget_by'] ) {
			$instance['katb_display_widget_by'] = 'random';
		}
		// Layout option 1-12.
		if ( intval( $instance['katb_display_widget_layout_override'] ) < 1 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} elseif ( intval( $instance['katb_display_widget_layout_override'] ) > 12 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} elseif ( '0' !== $instance['katb_display_widget_layout_override'] ) {
			$instance['katb_display_widget_layout_override'] = sanitize_text_field( $instance['katb_display_widget_layout_override'] );
		}
		// Schema override.
		if ( 'yes' !== $instance['katb_display_widget_schema_override'] && 'no' !== $instance['katb_display_widget_schema_override'] ) {
			$instance['katb_display_widget_schema_override'] = 'default';
		}
		return $instance;
	}
	/**
	 * Display the widget
	 *
	 * @param array $args is the arguments for the widget.
	 * @param array $instance is the instance parameters for the widget.
	 *
	 * @uses katb_get_options() user options from katb_functions.php
	 * @uses katb_widget_get_testimonials() from this file
	 * @uses katb_widget_schema_company_aggregate() from this file
	 * @uses katb_widget_display_testimonial () from this file
	 */
	public function widget( $args, $instance ) {
		// Get user options.
		global $katb_options;
		$katb_options             = katb_get_options();
		$company_name             = sanitize_text_field( $katb_options['katb_schema_company_name'] );
		$company_website          = esc_url( $katb_options['katb_schema_company_url'] );
		$use_aggregate_group_name = $katb_options['katb_use_group_name_for_aggregate'];
		$custom_aggregate_name    = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
		$use_schema               = $katb_options['katb_use_schema'];

		$katb_tdata_array = array();
		echo wp_kses_post( $args['before_widget'] );
		$title = apply_filters( 'widget_title', empty( $instance['katb_display_widget_title'] ) ? '' : $instance['katb_display_widget_title'], $instance, $this->id_base );
		if ( ! empty( $title ) ) {
			echo wp_kses_post( $args['before_title'] ) . wp_kses_post( $title ) . wp_kses_post( $args['after_title'] );
		}
		$group           = sanitize_text_field( $instance['katb_display_widget_group'] );
		$number          = sanitize_text_field( $instance['katb_display_widget_number'] );
		$by              = sanitize_text_field( $instance['katb_display_widget_by'] );
		$rotate          = sanitize_text_field( $instance['katb_display_widget_rotate'] );
		$ids             = sanitize_text_field( $instance['katb_display_widget_ids'] );
		$layout_override = sanitize_text_field( $instance['katb_display_widget_layout_override'] );
		$schema_override = sanitize_text_field( $instance['katb_display_widget_schema_override'] );
		// Enable testimonial slider.
		if ( 'yes' === $rotate ) {
			$rotate = true;
		}
		// schema override - change if yes or no do nothing if default.
		if ( 'yes' === $schema_override ) {
			$use_schema = true;
		} elseif ( 'no' === $schema_override ) {
			$use_schema = false;
		}
		// OK let's start by getting the testimonial data from the database.
		if ( '' !== $ids ) {
			$katb_tdata_array = katb_get_testimonials_from_ids( $ids );
		} else {
			$use_pagination   = 0;
			$katb_tdata_array = katb_get_testimonials( $group, $number, $by, $rotate, $use_pagination );
		}
		// Testimonials in 0.
		$katb_widget_tdata = $katb_tdata_array[0];
		// Nomber of testimonials in 1.
		$katb_widget_tnumber = $katb_tdata_array[1];
		// Initialize error.
		$katb_widget_error = '';

		if ( 2 > $katb_widget_tnumber && true === $rotate ) {
			$katb_widget_error = esc_html__( 'You must have 2 approved testimonials to use a rotated display!', 'testimonial-basics' );
		} elseif ( 0 === $katb_widget_tnumber ) {
			$katb_widget_error = esc_html__( 'There are no approved testimonials to display!', 'testimonial-basics' );
		}
		// Lets display the selected testimonial(s).
		if ( '' !== $katb_widget_error ) {
			?>
			<div class="katb_display_widget_error"><?php echo esc_html( $katb_widget_error ); ?></div>
			<?php
		} else {
			katb_widget_display_testimonial( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group, $layout_override );
		}
		?>
		<br style="clear:both;" />
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}
}//end class
/**
 * This function displays the testimonial.
 *
 * @param boolean $use_schema switch to use schema markup.
 * @param array   $katb_widget_tdata testimonial data.
 * @param string  $katb_widget_tnumber total number of testimonials.
 * @param boolean $rotate switch to set up slider.
 * @param string  $group_name group name from widget data.
 * @param string  $layout_override is the layout to use.
 *
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_validate_gravatar() check for gravatar from this file
 * @uses katb_widget_popup() set up popup  from this file
 * @uses katb_widget_testimonial_wrap_div() sets up main formatting div wrap from this file
 * @uses katb_meta_widget_top() html for top meta from this file
 * @uses katb_testimonial_excerpt_filter()  from this file
 * @uses katb_widget_insert_gravatar()  from this file
 * @uses katb_meta_widget_bottom() html for bottom meta from this file
 */
function katb_widget_display_testimonial( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group_name, $layout_override ) {
	// Get user options.
	global $katb_options;
	$use_ratings              = $katb_options['katb_use_ratings'];
	$use_excerpts             = $katb_options['katb_widget_use_excerpts'];
	$use_gravatars            = $katb_options['katb_widget_use_gravatars'];
	$use_round_images         = $katb_options['katb_widget_use_round_images'];
	$use_gravatar_substitute  = $katb_options['katb_widget_use_gravatar_substitute'];
	$gravatar_size            = intval( $katb_options['katb_widget_gravatar_size'] );
	$layout                   = sanitize_text_field( $katb_options['katb_widget_layout_option'] );
	$use_formatted_display    = $katb_options['katb_widget_use_formatted_display'];
	$katb_widget_height       = intval( $katb_options['katb_widget_rotator_height'] );
	$katb_widget_speed        = intval( $katb_options['katb_widget_rotator_speed'] );
	$katb_widget_transition   = sanitize_text_field( $katb_options['katb_widget_rotator_transition'] );
	$company_name             = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website          = esc_url( $katb_options['katb_schema_company_url'] );
	$use_aggregate_group_name = $katb_options['katb_use_group_name_for_aggregate'];
	$custom_aggregate_name    = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$show_date                = $katb_options['katb_widget_show_date'];
	$show_location            = $katb_options['katb_widget_show_location'];
	$show_website             = $katb_options['katb_widget_show_website'];
	$show_custom1             = $katb_options['katb_widget_show_custom1'];
	$show_custom2             = $katb_options['katb_widget_show_custom2'];
	$custom_title             = $katb_options['katb_widget_title_fallback'];
	$use_title                = $katb_options['katb_widget_show_title'];
	$length                   = intval( $katb_options['katb_widget_excerpt_length'] );
	$use_gdpr                 = $katb_options['katb_use_gdpr'];
	$gdpr_remove_permalink    = $katb_options['katb_gdpr_remove_permalink'];
	// Set up widget height restriction if any.
	if ( 'variable' !== $katb_widget_height ) {
		$katb_widget_height_option         = 'style="min-height:' . $katb_widget_height . 'px;overflow:hidden;"';
		$katb_widget_height_outside        = $katb_widget_height + 20;
		$katb_widget_height_option_outside = 'style="min-height:' . $katb_widget_height_outside . 'px;overflow:hidden;"';
	} else {
		$katb_widget_height_option         = '';
		$katb_widget_height_option_outside = '';
	}
	// Layout Override.
	if ( '0' !== $layout_override ) {
		if ( '1' === $layout_override ) {
			$layout                = 'Top Meta'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '2' === $layout_override ) {
			$layout                = 'Bottom Meta'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '3' === $layout_override ) {
			$layout                = 'Image & Meta Top'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '4' === $layout_override ) {
			$layout                = 'Image & Meta Bottom'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '5' === $layout_override ) {
			$layout                = 'Centered Image & Meta Top'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '6' === $layout_override ) {
			$layout                = 'Centered Image & Meta Bottom'; // translate ok.
			$use_formatted_display = false;
		} elseif ( '7' === $layout_override ) {
			$layout                = 'Top Meta'; // translate ok.
			$use_formatted_display = true;
		} elseif ( '8' === $layout_override ) {
			$layout                = 'Bottom Meta'; // translate ok.
			$use_formatted_display = true;
		} elseif ( '9' === $layout_override ) {
			$layout                = 'Image & Meta Top'; // translate ok.
			$use_formatted_display = true;
		} elseif ( '10' === $layout_override ) {
			$layout                = 'Image & Meta Bottom'; // translate ok.
			$use_formatted_display = true;
		} elseif ( '11' === $layout_override ) {
			$layout                = 'Centered Image & Meta Top'; // translate ok.
			$use_formatted_display = true;
		} elseif ( '12' === $layout_override ) {
			$layout                = 'Centered Image & Meta Bottom'; // translate ok.
			$use_formatted_display = true;
		}
	}
	// Use formatted display class add.
	if ( true === $use_formatted_display ) {
		$format = '';
	} else {
		$format = '_basic';
	}
	/**
	 * Since ver 4.1.0 added Image & Meta Top and Image & Meta Bottom layouts
	 * to allow independent styling will add the following classes when needed
	 * note this is different from the content mods as an extra class was added
	 * rather then appending classes
	 */
	if ( 'Image & Meta Top' === $layout ) {
		$new_layout_class = ' img_meta_top';
	} elseif ( 'Image & Meta Bottom' === $layout ) {
		$new_layout_class = ' img_meta_bot';
	} else {
		$new_layout_class = '';
	}
	// Use schema setup?
	if ( true === $use_schema ) {
		$fileschema = '-schema';
	} else {
		$fileschema = '-noschema';
	}
	// Set up slider?
	if ( true === $rotate ) {
		$filerotate = '-rotate';
	} else {
		$filerotate = '-norotate';
	}
	// Set up layout.
	if ( 'Top Meta' === $layout ) {
		$filelayout = '-top';
	} elseif ( 'Bottom Meta' === $layout ) {
		$filelayout = '-bottom';
	} elseif ( 'Image & Meta Top' === $layout ) {
		$filelayout = '-imagetop';
	} elseif ( 'Image & Meta Bottom' === $layout ) {
		$filelayout = '-imagebottom';
	} elseif ( 'Centered Image & Meta Top' === $layout ) {
		$filelayout = '-centerimagetop';
	} elseif ( 'Centered Image & Meta Bottom' === $layout ) {
		$filelayout = '-centerimagebottom';
	} else {
		$filelayout = '-top';}
	// load the layout file.
	require dirname( __FILE__ ) . '/template-parts-widget/widget' . $fileschema . $filerotate . $filelayout . '.php';
}
/**
 * This function is called if the widget requires a schema aggregate set up.
 * It sets up the company name and website in meta tags, and does a aggregate
 * average rating.
 *
 * @param string  $company_name user option.
 * @param string  $company_website user option.
 * @param string  $group_name user option.
 * @param boolean $use_aggregate_group_name user option.
 * @param string  $custom_aggregate_name user option.
 */
function katb_widget_schema_company_aggregate( $company_name, $company_website, $group_name, $use_aggregate_group_name, $custom_aggregate_name ) {
	// Company name and website meta.
	?>
	<meta content="<?php echo esc_attr( stripcslashes( $company_name ) ); ?>" itemprop="name" />
	<meta content="<?php echo esc_url( $company_website ); ?>" itemprop="url" />
	<?php
	// Aggregate rating if ratings are being used.
	global $wpdb,$tablename,$katb_options;
	$tablename   = $wpdb->prefix . 'testimonial_basics';
	$use_ratings = $katb_options['katb_use_ratings'];
	if ( true === $use_ratings ) {
		// Query database.
		if ( 'all' !== $group_name ) {
			$aggregate_data           = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ", ARRAY_A );// phpcs:ignore
			$aggregate_total_approved = $wpdb->num_rows;// phpcs:ignore
		} else {
			$aggregate_data           = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ", ARRAY_A );// phpcs:ignore
			$aggregate_total_approved = $wpdb->num_rows;// phpcs:ignore
		}
		// Get the average of the ratings.
		$count = 0;
		$sum   = 0;
		for ( $j = 0; $j < $aggregate_total_approved; $j++ ) {
			$rating = (float) $aggregate_data[ $j ]['tb_rating'];
			if ( '' !== $rating && 0 < $rating ) {
				$count++;
				$sum = $sum + (float) $aggregate_data[ $j ]['tb_rating'];
			}
		}
		if ( 0 === $count ) {
			$count = 1;
		}
		$avg_rating = round( $sum / $count, 1 );
		if ( 1 < $count && 0 < $avg_rating ) {
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
				<?php
				if ( '' !== $custom_aggregate_name ) {
					?>
					<meta content="<?php echo esc_attr( stripcslashes( $custom_aggregate_name ) ); ?>" itemprop="itemreviewed" />
					<?php
				} else {
					?>
					<meta content="<?php echo esc_attr( stripcslashes( $group_name ) ); ?>" itemprop="itemreviewed" />
					<?php
				}
				?>
				<div itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
					<meta content="<?php echo esc_attr( $avg_rating ); ?>" itemprop="average"/>
					<meta content="0" itemprop="worst" />
					<meta content="5" itemprop="best" />
				</div>
				<meta content="<?php echo esc_attr( $count ); ?>" itemprop="votes" />
				<meta content="<?php echo esc_attr( $aggregate_total_approved ); ?>" itemprop="count" />
			</div>
			<?php
		}
	}
}
