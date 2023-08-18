<?php
/**
 * This file holds many of the functions used in Testimonial Basics
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/*
 * Function Index
 * Content Area Display Functions
 *   katb_content_display()----------------------------------------------- ~   89
 *   katb_insert_gravatar()----------------------------------------------- ~  170
 *   katb_validate_gravatar()--------------------------------------------- ~  207
 *   katb_get_title_html()------------------------------------------------ ~  230
 *   katb_get_rating_html()----------------------------------------------- ~  263
 *   katb_get_content_html()---------------------------------------------- ~  299
 *   katb_get_author_html()----------------------------------------------- ~  337
 *   katb_get_location_html()--------------------------------------------- ~  365
 *   katb_get_date_html()------------------------------------------------- ~  385
 *   katb_get_custom1_html()---------------------------------------------- ~  414
 *   katb_get_custom2_html()---------------------------------------------- ~  433
 *   katb_get_website_html()---------------------------------------------- ~  452
 *   katb_get_gdpr_link()------------------------------------------------- ~  472
 * Excerpts and Popups
 *   katb_setup_popup()--------------------------------------------------- ~  511
 *   katb_testimonial_excerpt_filter()------------------------------------ ~  586
 *   katb_popup_required-------------------------------------------------- ~  632
 * Schema Functions
 *   katb_company_aggregate_display()------------------------------------- ~  674
 *   katb_schema_aggregate_markup----------------------------------------- ~  742
 * Database Retrieval Functions()
 *   katb_get_testimonials_from_ids()------------------------------------- ~  913
 *   katb_get_testimonials()---------------------------------------------- ~  958
 * Page Navigation Functions
 *   katb_setup_pagination()---------------------------------------------- ~ 1111
 *   katb_display_pagination ()------------------------------------------- ~ 1220
 *   katb_get_display_pagination_string()--------------------------------- ~ 1294
 *   katb_offset_setup ()------------------------------------------------- ~ 1375
 * Style Functions
 *   katb_css_rating()---------------------------------------------------- ~ 1445
 *   katb_hex_to_rgba()--------------------------------------------------- ~ 1545
 *   katb_custom_css()---------------------------------------------------- ~ 1563
 * Email Functions
 *   katb_email_notification()-------------------------------------------- ~ 1734
 *   katb_remove_testimonial_request()------------------------------------ ~ 1767
 *   katb_wp_mail_content_type()------------------------------------------ ~ 1819
 * Captcha Functions
 *   katb_bw_captcha()---------------------------------------------------- ~ 1836
 *   katb_color_captcha()------------------------------------------------- ~ 1892
 *   katb_color_captcha_2()----------------------------------------------- ~ 1935
 *   katb_recaptcha_tag()------------------------------------------------- ~ 2012
 * Display/Input in code
 *   katb_testimonial_basics_display_in_code()---------------------------- ~ 2042
 *   katb_testimonial_basics_input_in_code()------------------------------ ~ 2104
 * Other Functions
 *   katb_allowed_html()-------------------------------------------------- ~ 2138
 */
/**
 * ====================================================================================
 *                         Content Area Display Functions
 * ====================================================================================
 */

/**
 * This is the initial function call to display the testimonials in the content area.
 *
 * @param boolean $use_formatted_display yes or no.
 * @param boolean $use_schema yes or no.
 * @param string  $katb_tnumber total number of testimonials.
 * @param array   $katb_tdata array of testimonial data.
 * @param boolean $katb_rotate yes or no.
 * @param string  $layout top meta or bottom meta.
 * @param string  $group_name group name from shortcode.
 *
 * @uses katb_get_options() user options for plugin from katb_functions.php
 * @uses katb_company_aggregate_display() displays summary of testimonials from this file
 * @uses katb_validate_gravatar() checks for valid gravatar from katb_functions.php
 * @uses katb_setup_popup() setups the popup from this file
 * @uses katb_testimonial_wrap_div() sets up div wrap for options from this file
 * @uses katb_meta_top() supplies top meta string if required from this file
 * @uses katb_insert_gravatar () returns gravatar set up from this file
 * @uses katb_testimonial_excerpt_filter() excerpt for testimonial from katb_functions.php
 * @uses katb_meta_bottom () returns the bottom meta strip from this file
 */
function katb_content_display( $use_formatted_display, $use_schema, $katb_tnumber, $katb_tdata, $katb_rotate, $layout, $group_name ) {
	global $katb_options;
	$use_ratings                  = $katb_options['katb_use_ratings'];
	$use_excerpts                 = $katb_options['katb_use_excerpts'];
	$use_title                    = $katb_options['katb_show_title'];
	$use_gravatars                = $katb_options['katb_use_gravatars'];
	$use_round_images             = $katb_options['katb_use_round_images'];
	$use_gravatar_substitute      = $katb_options['katb_use_gravatar_substitute'];
	$gravatar_size                = intval( $katb_options['katb_gravatar_size'] );
	$company_name                 = esc_html( $katb_options['katb_schema_company_name'] );
	$company_website              = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company              = $katb_options['katb_schema_display_company'];
	$display_aggregate            = $katb_options['katb_schema_display_aggregate'];
	$display_reviews              = $katb_options['katb_schema_display_reviews'];
	$use_group_name_for_aggregate = $katb_options['katb_use_group_name_for_aggregate'];
	$custom_aggregate_name        = esc_html( $katb_options['katb_custom_aggregate_review_name'] );
	$custom_title                 = esc_html( $katb_options['katb_title_fallback'] );
	$katb_height                  = intval( $katb_options['katb_rotator_height'] );
	$katb_speed                   = intval( $katb_options['katb_rotator_speed'] );
	$katb_transition              = esc_html( $katb_options['katb_rotator_transition'] );
	$length                       = intval( $katb_options['katb_excerpt_length'] );
	$use_gdpr                     = $katb_options['katb_use_gdpr'];
	$gdpr_remove_permalink        = $katb_options['katb_gdpr_remove_permalink'];
	// Formatted display?
	if ( true === $use_formatted_display ) {
		$format = '';
	} else {
		$format = '_basic';
	}
	// Set up constant height option for rotated testimonials.
	if ( true === $katb_rotate && 'variable' !== $katb_height ) {
		$katb_height_option         = 'style="min-height:' . esc_attr( $katb_height ) . 'px;overflow:hidden;"';
		$katb_height_outside        = $katb_height + 20;
		$katb_height_option_outside = 'style="min-height:' . esc_attr( $katb_height_outside ) . 'px;overflow:hidden;"';
	} else {
		$katb_height_option         = '';
		$katb_height_option_outside = '';
	}
	// If we are not displaying anything turn off the schema.
	if ( false === $display_company && false === $display_aggregate && false === $display_reviews ) {
		$use_schema = false;
	}
	// Use schema?.
	if ( true === $use_schema ) {
		$fileschema = '-schema';
	} else {
		$fileschema = '-noschema';
	}
	// Set filerotate string.
	if ( 'Mosaic' === $layout ) {
		$filerotate = '';
	} elseif ( true === $katb_rotate ) {
		$filerotate = '-rotate';
	} else {
		$filerotate = '-norotate';
	}
	// Set filelayout string.
	if ( 'Side Meta' === $layout ) {
		$filelayout = '-side';
	} elseif ( 'Bottom Meta' === $layout ) {
		$filelayout = '-bottom';
	} elseif ( 'Mosaic' === $layout ) {
		$filelayout = '-mosaic';
	} else {
		$filelayout = '-top'; }
	// Load the layout file.
	require dirname( __FILE__ ) . '/template-parts-content/content' . $fileschema . $filerotate . $filelayout . '.php';
}

/**
 * This function is a helper function to inset a gravatar/image if one exists
 *
 * @param string  $image_url if uploaded image, this is the url.
 * @param string  $gravatar_size user option.
 * @param boolean $use_gravatars user option.
 * @param boolean $use_round_images user option.
 * @param boolean $use_gravatar_substitute user option.
 * @param string  $email address of author.
 *
 * @return $html gravatar insert html
 */
function katb_insert_gravatar( $image_url, $gravatar_size, $use_gravatars, $use_round_images, $use_gravatar_substitute, $email ) {
	// If uploaded photo use that, else use gravatar if selected and available.
	if ( true === $use_round_images ) {
		$round_class = '_round_image';
	} else {
		$round_class = '';
	}
	// If gravatars are enabled, check for valid avatar.
	if ( true === $use_gravatars && false === $use_gravatar_substitute ) {
		$has_valid_avatar = katb_validate_gravatar( $email );
	} else {
		$has_valid_avatar = false;
	}
	$html = '';
	if ( '' !== $image_url ) {
		$html .= '<span class="katb_avatar' . $round_class . '" style="width:' . esc_attr( $gravatar_size ) . 'px; height:auto;" ><img class="avatar" src="' . esc_url( $image_url ) . '" alt="Author Picture" /></span>';
	} elseif ( true === $use_gravatars && true === $has_valid_avatar ) {
		$size        = $gravatar_size;
		$avatar_html = get_avatar( $email, $size );
		$html       .= '<span class="katb_avatar' . $round_class . '" style="width:' . esc_attr( $gravatar_size ) . 'px; height:auto;" >' . $avatar_html . '</span>';
	} elseif ( true === $use_gravatars && true === $use_gravatar_substitute ) {
		$size        = $gravatar_size;
		$avatar_html = get_avatar( $email, $size );
		$html       .= '<span class="katb_avatar' . $round_class . '" style="width:' . esc_attr( $gravatar_size ) . 'px; height:auto;" >' . $avatar_html . '</span>';
	}
	return $html;
}

/**
 * Test if gravatar exists for a given email
 *
 * Source: http://codex.wordpress.org/Using_Gravatars.
 *
 * @param string $email is the email to use for the gravatar check.
 *
 * @return boolean $has_valid_avatar
 */
function katb_validate_gravatar( $email ) {
	// Craft a potential url and test its headers.
	$hash    = md5( strtolower( trim( $email ) ) );
	$uri     = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers( $uri ); // phpcs:ignore
	if ( ! preg_match( "|200|", $headers[0] ) ) { // phpcs:ignore
		$has_valid_avatar = false;
	} else {
		$has_valid_avatar = true;
	}
	return $has_valid_avatar;
}

/**
 * Helper function to display the title of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $use_title switch for diaplaying the title.
 * @param boolean $use_schema switch to use schema markup.
 * @param string  $individual_group_name is the group name.
 * @param string  $testimonial_title is the title entered.
 * @param string  $custom_title is the custom title.
 */
function katb_get_title_html( $use_title, $use_schema, $individual_group_name, $testimonial_title, $custom_title ) {
	if ( '' !== $testimonial_title ) {
		$name_to_use = $testimonial_title;
	} elseif ( '' !== $individual_group_name ) {
		$name_to_use = $individual_group_name;
	} else {
		$name_to_use = $custom_title;
	}
	if ( true === $use_title ) {
		?>
		<span class="katb_title">
			<?php echo esc_html( wp_unslash( $name_to_use ) ); ?>
			&nbsp;
		</span>
		<?php
	}
	if ( true === $use_schema ) {
		?>
		<div class = "katb_title" itemprop="itemReviewed" itemscope itemtype="http://schema.org/LocalBusiness">
			<meta itemprop="name" content="<?php echo esc_attr( wp_unslash( $name_to_use ) ); ?>">
		</div>
		<?php
	}
}

/**
 * Helper function to display the rating of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $use_ratings switch for using ratings.
 * @param boolean $use_schema switch to use schema markup.
 * @param string  $rating is the rating.
 */
function katb_get_rating_html( $use_ratings, $use_schema, $rating ) {
	if ( true === $use_ratings ) {
		if ( '' === $rating ) {
			$rating = 0; }
		if ( 0 < $rating ) {
			?>
			<span class="katb_css_rating">
				<?php echo katb_css_rating( $rating ); // phpcs:ignore ?>
			</span>
			<?php
			if ( true === $use_schema ) {
				?>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
					<meta itemprop="worstRating" content="0" />
					<meta itemprop="ratingValue" content="<?php echo esc_attr( $rating ); ?>" />
					<meta itemprop="bestRating" content="5" />
				</div>
				<?php
			}
		}
	}
}

/**
 * Helper function to display the content of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $use_schema switch to use schema markup.
 * @param boolean $format is the class add on for the format.
 * @param boolean $use_excerpts is a sitch to use excerpts.
 * @param string  $length is the length in words for the excerpt.
 * @param string  $gravatar_or_photo is the html for the gravatar or photo.
 * @param string  $content ia the html content for the testimonial.
 * @param string  $id is the testimonial id.
 * @param string  $source is either 'content' or 'widget'.
 */
function katb_get_content_html( $use_schema, $format, $use_excerpts, $length, $gravatar_or_photo, $content, $id, $source ) {
	if ( true === $use_schema ) {
		$schema_markup = 'itemprop="reviewBody"';
	} else {
		$schema_markup = ''; }
	if ( true === $use_excerpts ) {
		$text    = wpautop( wp_kses_post( wp_unslash( $content ) ) );
		$classid = 'katb_' . $source . '_' . sanitize_text_field( $id );
		$text    = katb_testimonial_excerpt_filter( $length, $text, $classid );
		?>
		<div class="katb_test_text<?php echo esc_attr( $format ); ?>" <?php echo $schema_markup;// phpcs:ignore ?>>
		<?php
			echo $gravatar_or_photo; // phpcs:ignore
			echo $text; // phpcs:ignore
		?>
		</div>
		<?php
	} else {
		$text = wpautop( wp_kses_post( wp_unslash( $content ) ) );
		?>
		<div class="katb_test_text<?php echo esc_attr( $format ); ?>" <?php echo $schema_markup;// phpcs:ignore ?>>
		<?php
			echo $gravatar_or_photo; // phpcs:ignore
			echo $text; // phpcs:ignore
		?>
		</div>
		<?php
	}
}

/**
 * Helper function to display the author of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $use_schema switch to use schema markup.
 * @param string  $author_name is the name of the testimonial author.
 * @param string  $divider is the html for a divider.
 */
function katb_get_author_html( $use_schema, $author_name, $divider ) {
	if ( true === $use_schema ) {
		?>
		<div itemprop="author" itemscope itemtype="http://schema.org/Person">
			<span class="katb_author" itemprop="name">
				<?php echo esc_html( wp_unslash( $author_name ) ); ?>
				<?php echo $divider; // phpcs:ignore ?>
			</span>
		</div>
		<?php
	} else {
		?>
		<span class="katb_author">
			<?php echo esc_html( wp_unslash( $author_name ) ); ?>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * Helper function to display the location of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $show_location switch to display the location.
 * @param string  $location is the location.
 * @param string  $divider is the html for a divider.
 */
function katb_get_location_html( $show_location, $location, $divider ) {
	if ( true === $show_location && '' !== $location ) {
		?>
		<span class="katb_location">
			<?php echo esc_html( wp_unslash( $location ) ); ?>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * Helper function to display the date of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $use_schema switch to use schema.
 * @param boolean $show_date switch to display the date.
 * @param string  $date is the date of the testimonial.
 * @param string  $divider is the html for a divider.
 */
function katb_get_date_html( $use_schema, $show_date, $date, $divider ) {
	if ( true === $show_date ) {
		$date = esc_html( $date );
		?>
		<span class="katb_date">
			<?php
			echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) );
			echo $divider; // phpcs:ignore
			?>
		</span>
		<?php
		if ( true === $use_schema ) {
			?>
			<meta itemprop="datePublished" content="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ); ?>">
			<?php
		}
		?>
		<?php
	}
}

/**
 * Helper function to display the custom1 of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $show_custom1 switch to display custom1 content.
 * @param string  $custom1 is the custom1 content.
 * @param string  $divider is the html for a divider.
 */
function katb_get_custom1_html( $show_custom1, $custom1, $divider ) {
	if ( true === $show_custom1 && '' !== $custom1 ) {
		?>
		<span class="katb_custom1">
			<?php echo esc_html( wp_unslash( $custom1 ) ); ?>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * Helper function to display the custom2 of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $show_custom2 switch to display custom2 content.
 * @param string  $custom2 is the custom2 content.
 * @param string  $divider is the html for a divider.
 */
function katb_get_custom2_html( $show_custom2, $custom2, $divider ) {
	if ( true === $show_custom2 && '' !== $custom2 ) {
		?>
		<span class="katb_custom2">
			<?php echo esc_html( wp_unslash( $custom2 ) ); ?>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * Helper function to display the website of the testimonial.
 * Used by content and widget display templates.
 *
 * @param boolean $show_website switch to display the website link.
 * @param string  $website is the website url.
 * @param string  $divider is the html for a divider.
 */
function katb_get_website_html( $show_website, $website, $divider ) {
	if ( true === $show_website && '' !== $website ) {
		?>
		<span class="katb_website">
			<a href="<?php echo esc_url( $website ); ?>" title="<?php esc_url( $website ); ?>" target="_blank" rel="nofollow" ><?php esc_html_e( 'Website', 'testimonial-basics' ); ?></a>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * Helper function to display the GDPR remove link.
 * Used by content and widget display templates.
 *
 * @param string $gdpr_remove_permalink remove page permalink.
 * @param string $tb_id is the id of the testimonial to be removed.
 * @param string $divider is the html for a divider.
 * @param string $widget_or_content indicates the source of the request, 'widget' or 'content'.
 */
function katb_get_gdpr_link( $gdpr_remove_permalink, $tb_id, $divider, $widget_or_content ) {
	global $katb_options;
	$use_gdpr = $katb_options['katb_use_gdpr'];
	if ( true === $use_gdpr && '' !== trim( $gdpr_remove_permalink ) ) {
		?>
		<span class="katb_remove_link <?php echo $widget_or_content; // phpcs:ignore ?>">
			<a href="<?php echo esc_url( $gdpr_remove_permalink ) . '?id=' . esc_attr( $tb_id ); ?>" title="<?php esc_attr_e( 'Request Removal', 'testimonial-basics' ); ?>" rel="nofollow" >
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewBox="0 0 16 16">
					<path d="M10 2h6v2h-6v-2z"></path>
					<path d="M13.599 5h-4.599v-1.944c-0.328-0.037-0.662-0.056-1-0.056-3.489 0-6.514 2.032-8 5 1.486 2.968 4.511 5 8 5s6.514-2.032 8-5c-0.584-1.167-1.407-2.189-2.401-3zM6.5 5c0.828 0 1.5 0.672 1.5 1.5s-0.672 1.5-1.5 1.5-1.5-0.672-1.5-1.5 0.672-1.5 1.5-1.5zM11.944 10.348c-1.181 0.753-2.545 1.152-3.944 1.152s-2.763-0.398-3.945-1.152c-0.94-0.6-1.736-1.403-2.335-2.348 0.598-0.946 1.395-1.749 2.335-2.348 0.061-0.039 0.123-0.077 0.185-0.114-0.156 0.427-0.241 0.888-0.241 1.369 0 2.209 1.791 4 4 4s4-1.791 4-4c0-0.481-0.085-0.942-0.241-1.369 0.062 0.037 0.124 0.075 0.185 0.114 0.94 0.6 1.737 1.403 2.335 2.348-0.598 0.946-1.395 1.749-2.335 2.348z"></path>
				</svg>
			</a>
			<?php echo $divider; // phpcs:ignore ?>
		</span>
		<?php
	}
}

/**
 * ===============================================================================================
 *               Excerpts and Popups
 * ===============================================================================================
 */

/**
 * This function sets up the html string for the popup testimonial if called.
 *
 * All popups are displayed the same, using the content display, no schema, top meta.
 *
 * @param string $i testimonial counter.
 * @param array  $katb_tdata testimonial data.
 * @param string $gravatar_or_photo is the html string for the image.
 * @param string $source is either 'content' or 'widget'.
 *
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_meta_top() top meta string from this file
 * @uses katb_meta_bottom() bottom meta string from this file
 * @uses katb_insert_gravatar()
 */
function katb_setup_popup( $i, $katb_tdata, $gravatar_or_photo, $source ) {
	global $katb_options;
	if ( 'content' === $source ) {
		$use_title    = $katb_options['katb_show_title'];
		$custom_title = $katb_options['katb_title_fallback'];
		$group_name   = $katb_tdata[ $i ]['tb_group'];
	} else {
		$use_title    = $katb_options['katb_widget_show_title'];
		$custom_title = $katb_options['katb_widget_title_fallback'];
	}
	$use_ratings  = $katb_options['katb_use_ratings'];
	$use_schema   = false;
	$use_excerpts = false;
	$format       = '_basic';
	$length       = 1000; // Just to be sure take excerpts out of the display.
	?>
	<div id="popwrap_katb_<?php echo esc_attr( $source ); ?>_<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>">
	<div class="katb_topopup" id="katb_<?php echo esc_attr( $source ); ?>_<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>">
		<div class="katb_close"></div>
		<div class="katb_popup_wrap katb_<?php echo esc_attr( $source ); ?>">
			<div class="katb_title_rating_wrap">
			<?php
				katb_get_title_html( $use_title, $use_schema, $katb_tdata[ $i ]['tb_group'], $katb_tdata[ $i ]['tb_title'], $custom_title );
				katb_get_rating_html( $use_ratings, $use_schema, $katb_tdata[ $i ]['tb_rating'] );
			?>
			</div>
			<div class="katb_meta_top">
				<?php
				$divider = '&nbsp;&nbsp;';
				katb_get_author_html( $use_schema, $katb_tdata[ $i ]['tb_name'], $divider );
				if ( 'content' === $source ) {
					katb_get_date_html( $use_schema, $katb_options['katb_show_date'], $katb_tdata[ $i ]['tb_date'], $divider );
					katb_get_location_html( $katb_options['katb_show_location'], $katb_tdata[ $i ]['tb_location'], $divider );
					katb_get_custom1_html( $katb_options['katb_show_custom1'], $katb_tdata[ $i ]['tb_custom1'], $divider );
					katb_get_custom2_html( $katb_options['katb_show_custom2'], $katb_tdata[ $i ]['tb_custom2'], $divider );
					katb_get_website_html( $katb_options['katb_show_website'], $katb_tdata[ $i ]['tb_url'], $divider );
				} else {
					katb_get_date_html( $use_schema, $katb_options['katb_widget_show_date'], $katb_tdata[ $i ]['tb_date'], $divider );
					katb_get_location_html( $katb_options['katb_widget_show_location'], $katb_tdata[ $i ]['tb_location'], $divider );
					katb_get_custom1_html( $katb_options['katb_widget_show_custom1'], $katb_tdata[ $i ]['tb_custom1'], $divider );
					katb_get_custom2_html( $katb_options['katb_widget_show_custom2'], $katb_tdata[ $i ]['tb_custom2'], $divider );
					katb_get_website_html( $katb_options['katb_widget_show_website'], $katb_tdata[ $i ]['tb_url'], $divider );
				}
				?>
			</div>
			<div class="katb_testimonial_wrap">
			<?php
				katb_get_content_html( $use_schema, $format, $use_excerpts, $length, $gravatar_or_photo, $katb_tdata[ $i ]['tb_testimonial'], $katb_tdata[ $i ]['tb_id'], $source );
			?>
			</div>
		</div>
	</div>
	<div class="katb_loader"></div>
	<div class="katb_excerpt_popup_bg" id="katb_<?php echo esc_attr( $source ); ?>_<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>_bg"></div>
	</div>
	<?php
}
add_action( 'katb_popup_html', 'katb_setup_popup' );

/**
 * EXCERPT FILTER
 *
 * @Author: Boutros AbiChedid
 * @Date:   June 20, 2011
 * @Websites: http://bacsoftwareconsulting.com/ ; http://blueoliveonline.com/
 * @Description: Preserves HTML formating to the automatically generated Excerpt.
 * Also Code modifies the default excerpt_length and excerpt_more filters.
 * http://bacsoftwareconsulting.com/blog/index.php/wordpress-cat/how-to-preserve-html-tags-in-wordpress-excerpt-without-a-plugin/
 * Modified by
 * @Author: Kevin Archibald
 *
 * @param string $length is the length to use in words.
 * @param string $text is the text.
 * @param string $classid is the classid used by the popup.
 */
function katb_testimonial_excerpt_filter( $length, $text, $classid ) {
	global $katb_options, $katb_excerpt_required;
	$katb_excerpt_required = false;
	$more_label            = $katb_options['katb_excerpt_more_label'];
	// Initiate some variables.
	$katb_excerpt = strip_shortcodes( $text );
	// Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = $length;
	$excerpt_length     = apply_filters( 'excerpt_length', $excerpt_word_count );
	$tokens             = array();
	$excerptoutput      = '';
	$no_tag_count       = 0;
	// Divide the string into tokens; HTML tags, or words, followed by any whitespace.
	preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $katb_excerpt, $tokens );
	// Do da excerpt.
	foreach ( $tokens[0] as $token ) {
		if ( trim( wp_strip_all_tags( $token ) ) === trim( $token ) ) {
			// This token is not a tag.
			$no_tag_count++;
			if ( $no_tag_count <= $excerpt_word_count ) {
				$excerptoutput .= $token;
			}
		} else {
			$excerptoutput .= $token;
		}
	}
	$katb_excerpt = trim( force_balance_tags( $excerptoutput ) );
	$excerpt_end  = '<a href="#" class="katb_excerpt_more" data-id="' . esc_attr( $classid ) . '" > ...' . esc_html( $more_label ) . '</a>';
	if ( $no_tag_count >= $excerpt_word_count ) {
		// After the content.
		$katb_excerpt         .= $excerpt_end; // Add read more in new paragraph.
		$katb_excerpt_required = true;
	}
	return $katb_excerpt;
}

/**
 * Check if popup is required
 *
 * This function is used exclusively for the mosaic pages because popups are not integral with the testimonial.
 * That is all popups are set up in one go.
 * The function checks to see if a popup is required.
 *
 * @param string $length is the length of the excerpt in words.
 * @param string $text is the testimonial content.
 */
function katb_popup_required( $length, $text ) {
	global $katb_options;
	// Initiate some variables.
	$katb_excerpt = strip_shortcodes( $text );
	// Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = $length;
	$excerpt_length     = apply_filters( 'excerpt_length', $excerpt_word_count );
	$tokens             = array();
	$no_tag_count       = 0;
	// Divide the string into tokens; HTML tags, or words, followed by any whitespace.
	preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $katb_excerpt, $tokens );
	foreach ( $tokens[0] as $token ) {
		if ( wp_strip_all_tags( $token ) === trim( $token ) ) {
			// This token is not a tag.
			$no_tag_count++;
		}
	}
	if ( $no_tag_count >= $excerpt_word_count ) {
		$katb_is_popup_required = true;
	} else {
		$katb_is_popup_required = false;
	}
	return $katb_is_popup_required;
}

/**
 * =============================================================================================
 *               Schema Functions
 * =============================================================================================
 */

/**
 * This function sets up the company and aggregate display and is only used for
 * if schema is selected and if the user wants to display them.
 *
 * @param boolean $use_formatted_display is the switch to use the custom formats.
 * @param string  $group_name group name to use for search of testimonials.
 * @param string  $layout is the layout code for the display.
 *
 * @uses katb_get_options() from katb_functions.php
 * @uses katb_schema_aggregate_markup() from this file
 */
function katb_company_aggregate_display( $use_formatted_display, $group_name, $layout ) {
	global $katb_options;
	$company_name                 = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website              = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company              = $katb_options['katb_schema_display_company'];
	$display_aggregate            = $katb_options['katb_schema_display_aggregate'];
	$display_reviews              = $katb_options['katb_schema_display_reviews'];
	$use_group_name_for_aggregate = $katb_options['katb_use_group_name_for_aggregate'];
	$custom_aggregate_name        = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$use_ratings                  = $katb_options['katb_use_ratings'];
	$html                         = '';
	if ( 'Side Meta' === $layout || 'Mosaic' === $layout ) {
		$side_meta_class = '_side_meta';
	} else {
		$side_meta_class = '';
	}
	if ( false === $display_company && false === $display_aggregate ) {
			// If company and aggregate info are not displayed use dummy classes to elimate css formatting.
			$html .= '<div class="katb_no_display_wrap">';
			$html .= '<div class="katb_no_display_box">';
	} else {
		if ( true === $use_formatted_display ) {
			$html .= '<div class="katb_schema_summary_wrap' . $side_meta_class . '">';
			$html .= '<div class="katb_schema_summary_box' . $side_meta_class . '">';
		} else {
			$html .= '<div class="katb_schema_summary_wrap_basic' . $side_meta_class . '">';
			$html .= '<div class="katb_schema_summary_box_basic' . $side_meta_class . '">';
		}
	}
	if ( false === $display_company ) {
		$html .= '<meta content="' . wp_unslash( esc_attr( $company_name ) ) . '" itemprop="name" />';
		$html .= '<meta content="' . wp_unslash( esc_url( $company_website ) ) . '" itemprop="url" />';
	} else {
		$html .= '<div class="katb_schema_company_wrap' . $side_meta_class . '">';
		if ( is_rtl() && false === $katb_options['katb_remove_rtl_support'] ) {
			$html .= '<span class="katb_company_name" itemprop="name">' . wp_unslash( esc_attr( $company_name ) ) . ' : ' . __( 'Company', 'testimonial-basics' ) . '</span><br/>';
			$html .= '<span class="katb_company_website"><a class="company_website" href="' . wp_unslash( esc_url( $company_website ) ) . '" title="Company Website" target="_blank" itemprop="url">' . $company_website . '</a> : ' . __( 'Website', 'testimonial-basics' ) . '</span>';
		} else {
			$html .= '<span class="katb_company_name" itemprop="name">' . __( 'Company', 'testimonial-basics' ) . ' : ' . wp_unslash( esc_attr( $company_name ) ) . '</span><br/>';
			$html .= '<span class="katb_company_website">' . __( 'Website', 'testimonial-basics' ) . ' : <a class="company_website" href="' . wp_unslash( esc_url( $company_website ) ) . '" title="Company Website" target="_blank" itemprop="url">' . $company_website . '</a></span>';
		}
		$html .= '</div>';
	}
	if ( true === $use_ratings ) {
		// Call function to display the aggregate rating.
		$html .= katb_schema_aggregate_markup( $display_aggregate, $group_name, $use_group_name_for_aggregate, $custom_aggregate_name, $layout );
	}
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}

/**
 * This function sets up the html string for the aggregate markup
 *
 * The database is queried for the group name to get the average rating, the
 * review count with ratings and the total review count. It then sets up the
 * return string based on whether or not the summary is to be dispayed or hidden with
 * meta tags
 *
 * @param boolean $display_aggregate is a switch to display the aggregate.
 * @param string  $group_name is the group name.
 * @param boolean $use_group_name_for_aggregate is a switch to use the group name.
 * @param string  $custom_aggregate_name is the cusom aggregate name.
 * @param string  $layout is the layout class addon.
 *
 * @return $agg_html string of html
 */
function katb_schema_aggregate_markup( $display_aggregate, $group_name, $use_group_name_for_aggregate, $custom_aggregate_name, $layout ) {
	// Setup database table.
	global $wpdb,$tablename, $katb_options;
	$tablename = $wpdb->prefix . 'testimonial_basics';
	// Laout stuff.
	if ( 'Side Meta' === $layout || 'Mosaic' === $layout ) {
		$side_meta_class = '_side_meta';
	} else {
		$side_meta_class = ''; }
	// Initialize.
	$agg_html = '';
	// Query database.
	if ( 'all' !== $group_name ) {
		$aggregate_data           = $wpdb->get_results( $wpdb->prepare( "SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s", '1', $group ), ARRAY_A );// phpcs:ignore
		$aggregate_total_approved = $wpdb->num_rows;
	} else {
		$aggregate_data           = $wpdb->get_results( $wpdb->prepare( "SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = %s", '1' ), ARRAY_A );// phpcs:ignore
		$aggregate_total_approved = $wpdb->num_rows;
	}
	$count = 0;
	$sum   = 0;
	for ( $j = 0; $j < $aggregate_total_approved; $j++ ) {
		$rating = (float) $aggregate_data[ $j ]['tb_rating'];
		if ( '' !== $rating && 0 < $rating ) {
			$count++;
			$sum = $sum + (float) $aggregate_data[ $j ]['tb_rating'];
		}
	}
	$total_votes = $count;
	if ( 0 === $count ) {
		$avg_rating = 0;
	} else {
		$avg_rating = round( $sum / $count, 1 );
	}
	if ( 0 === $avg_rating ) {
		$rounded_avg_rating = 0;
	} else {
		// Round to nearest 0.5 out of 5.
		if ( $avg_rating >= ceil( $avg_rating ) - 0.25 ) {
			$rounded_avg_rating = ceil( $avg_rating );
		} elseif ( $avg_rating >= ceil( $avg_rating ) - 0.75 ) {
			$rounded_avg_rating = ceil( $avg_rating ) - 0.50;
		} else {
			$rounded_avg_rating = floor( $avg_rating );
		}
	}
	if ( 1 < $count && 0 < $avg_rating && 0 < $rounded_avg_rating ) {
		if ( false === $display_aggregate ) {
			$agg_html .= '<div class="katb_no_display" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
			if ( true === $use_group_name_for_aggregate && 'all' !== $group_name ) {
				$agg_html .= '<meta content="' . wp_unslash( esc_attr( $group_name ) ) . '" itemprop="itemreviewed" />';
			} elseif ( false === $use_group_name_for_aggregate && '' !== $custom_aggregate_name ) {
				$agg_html .= '<meta content="' . wp_unslash( esc_attr( $custom_aggregate_name ) ) . '" itemprop="itemreviewed" />';
			} else {
				$agg_html .= '<meta content="' . __( 'All Reviews', 'testimonial-basics' ) . '" itemprop="itemreviewed" />';
			}
			$agg_html .= '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
			$agg_html .= '<meta content="' . wp_unslash( esc_attr( $avg_rating ) ) . '" itemprop="average" />';
			$agg_html .= '<meta content="0" itemprop="worst" />';
			$agg_html .= '<meta content="5" itemprop="best" />';
			$agg_html .= '</span>';
			$agg_html .= '<meta content="' . wp_unslash( esc_attr( $total_votes ) ) . '" itemprop="votes" />';
			$agg_html .= '<meta content="' . wp_unslash( esc_attr( $aggregate_total_approved ) ) . '" itemprop="count" />';
			$agg_html .= '</div>';
		} else {

			$agg_html .= '<div class="katb_aggregate_wrap' . $side_meta_class . '" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
			$agg_html .= '<span class="katb_aggregate_source">';
			if ( is_rtl() && false === $katb_options['katb_remove_rtl_support'] ) {
				if ( '' === $side_meta_class ) {
					$agg_html .= '<span class="aggregate_review_label">' . __( 'Aggregate Review', 'testimonial-basics' ) . '&nbsp;:</span>';
				}
				if ( true === $use_group_name_for_aggregate && 'all' !== $group_name ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . wp_unslash( esc_attr( $group_name ) ) . '</span>';
				} elseif ( false === $use_group_name_for_aggregate && '' !== $custom_aggregate_name ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . wp_unslash( esc_attr( $custom_aggregate_name ) ) . '</span>';
				} else {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . esc_html__( 'All Reviews', 'testimonial-basics' ) . '</span>';
				}
				if ( '' !== $side_meta_class ) {
					$agg_html .= '&nbsp;:&nbsp;<span class="aggregate_review_label">' . esc_html__( 'Aggregate Review', 'testimonial-basics' ) . '</span>';
				}
			} else {
				$agg_html .= '<span class="aggregate_review_label">' . esc_html__( 'Aggregate Review', 'testimonial-basics' ) . ' :</span> ';
				if ( true === $use_group_name_for_aggregate && 'all' !== $group_name ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . wp_unslash( esc_attr( $group_name ) ) . '</span>';
				} elseif ( false === $use_group_name_for_aggregate && '' !== $custom_aggregate_name ) {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . wp_unslash( esc_attr( $custom_aggregate_name ) ) . '</span>';
				} else {
					$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">' . esc_html__( 'All Reviews', 'testimonial-basics' ) . '</span>';
				}
			}
			$agg_html .= '</span>';
			$agg_html .= '<span class="katb_aggregate_results">';
			if ( is_rtl() && false === $katb_options['katb_remove_rtl_support'] ) {
				$agg_html .= '<span class="katb_css_rating katb_aggy">';
				$agg_html .= katb_css_rating( $rounded_avg_rating );
				$agg_html .= '&nbsp;</span>';
				$agg_html .= '<span class="katb_aggregate_data" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
				$agg_html .= '<span class="best" itemprop="best">5</span>';
				$agg_html .= '<span class="out_of">&nbsp;' . esc_html__( 'out of', 'testimonial-basics' ) . '&nbsp;</span>';
				$agg_html .= '<span class="average_number" itemprop="average">' . wp_unslash( esc_attr( $avg_rating ) ) . '&nbsp;,&nbsp;</span>';
				$agg_html .= '</span>';
				if ( 1 === $total_votes ) {
					$agg_html .= '<span class="votes_label">' . __( 'vote', 'testimonial-basics' ) . '&nbsp;</span>';
					$agg_html .= '<span class="total_votes" itemprop="votes">' . wp_unslash( esc_attr( $total_votes ) ) . '&nbsp;,&nbsp;</span>';
				} elseif ( 0 === $total_votes ) {
					$agg_html .= '<span class="votes_label">' . __( 'not rated', 'testimonial-basics' ) . '&nbsp;,&nbsp;</span>';
				} else {
					$agg_html .= '<span class="votes_label">' . __( 'votes', 'testimonial-basics' ) . '&nbsp;</span>';
					$agg_html .= '<span class="total_votes" itemprop="votes">' . wp_unslash( esc_attr( $total_votes ) ) . '&nbsp;,&nbsp;</span>';
				}

				if ( 0 === $aggregate_total_approved ) {
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'no reviews yet', 'testimonial-basics' ) . '</span>';
				} elseif ( 1 === $aggregate_total_approved ) {
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'review', 'testimonial-basics' ) . '&nbsp;</span>';
					$agg_html .= '<span class="total_reviews">' . wp_unslash( esc_attr( $aggregate_total_approved ) ) . '&nbsp;</span>';
				} else {
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'reviews', 'testimonial-basics' ) . '&nbsp;</span>';
					$agg_html .= '<span class="total_reviews">' . wp_unslash( esc_attr( $aggregate_total_approved ) ) . '&nbsp;</span>';
				}
			} else {
				$agg_html .= '<span class="katb_css_rating katb_aggy">';
				$agg_html .= katb_css_rating( $rounded_avg_rating );
				$agg_html .= '&nbsp;</span>';
				$agg_html .= '<span class="katb_aggregate_data" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
				$agg_html .= '<span class="average_number" itemprop="average">' . wp_unslash( esc_attr( $avg_rating ) ) . '</span>';
				$agg_html .= '<span class="out_of">&nbsp;' . esc_html__( 'out of', 'testimonial-basics' ) . '&nbsp;</span>';
				$agg_html .= '<span class="best" itemprop="best">5&nbsp;,&nbsp;</span>';
				$agg_html .= '</span>';
				if ( 1 === $total_votes ) {
					$agg_html .= '<span class="total_votes" itemprop="votes">' . wp_unslash( esc_attr( $total_votes ) ) . '&nbsp;</span>';
					$agg_html .= '<span class="votes_label">' . esc_html__( 'vote', 'testimonial-basics' ) . '&nbsp;,&nbsp;</span>';
				} elseif ( 0 === $total_votes ) {
					$agg_html .= '<span class="votes_label">' . esc_html__( 'not rated', 'testimonial-basics' ) . '&nbsp;,&nbsp;</span>';
				} else {
					$agg_html .= '<span class="total_votes" itemprop="votes">' . wp_unslash( esc_attr( $total_votes ) ) . '&nbsp;</span>';
					$agg_html .= '<span class="votes_label">' . esc_html__( 'votes', 'testimonial-basics' ) . '&nbsp;,&nbsp;</span>';
				}
				if ( 0 === $aggregate_total_approved ) {
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'no reviews yet', 'testimonial-basics' ) . '</span>';
				} elseif ( 1 === $aggregate_total_approved ) {
					$agg_html .= '<span class="total_reviews">' . wp_unslash( esc_attr( $aggregate_total_approved ) ) . '&nbsp;</span>';
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'review', 'testimonial-basics' ) . '</span>';
				} else {
					$agg_html .= '<span class="total_reviews">' . wp_unslash( esc_attr( $aggregate_total_approved ) ) . '&nbsp;</span>';
					$agg_html .= '<span class="reviews_label">' . esc_html__( 'reviews', 'testimonial-basics' ) . '</span>';
				}
			}
			$agg_html .= '</span>';
			$agg_html .= '</div>';
		}
	}
	return $agg_html;
}

/**
 * ================================================================================================
 *         Database Retrieval Functions
 * ================================================================================================
 */

/**
 * This function takes a string of id's and returns the testimonials and count
 * for the testimonial
 *
 * @param string $id is string of id's.
 *
 * @return array $katb_tdata_array testimonials and count
 */
function katb_get_testimonials_from_ids( $id ) {
	global $wpdb , $tablename;
	$tablename          = $wpdb->prefix . 'testimonial_basics';
	$id_picks           = array();
	$id_picks_processed = array();
	$id_picks           = explode( ',', $id );
	$katb_tdata_array   = array();
	$counter            = 0;
	foreach ( $id_picks as $pick ) {
		$id_picks_processed[ $counter ] = intval( $id_picks[ $counter ] );
		if ( 1 > $id_picks_processed[ $counter ] ) {
			$id_picks_processed[ $counter ] = 1;
		}
		$counter++;
	}
	$count  = 0;
	$count2 = 0;
	foreach ( $id_picks_processed as $pick ) {
		$pick_id = intval( $id_picks_processed[ $count ] );
		$tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_id` = %d", '1', $pick_id ), ARRAY_A );// phpcs:ignore
		$tnumber = $wpdb->num_rows;
		if ( 1 === $tnumber ) {
			$katb_tdata[ $count2 ] = $tdata[0];
			$count2++;
		}
		$count++;
	}
	$katb_tnumber        = $count2;
	$katb_tdata_array[0] = $katb_tdata;
	$katb_tdata_array[1] = $count2;
	return $katb_tdata_array;
}

/**
 * This function retrieves the testimonials and the number of testimomials
 * for all cases except when id's are input in the shortcode.
 *
 * @param string  $group is the grouping name for the testimonials.
 * @param string  $number is the number of testimonials to display.
 * @param string  $by is the method of testimonial selection.
 * @param string  $rotate a switch to rotate testimonials in a simple slider.
 * @param boolean $use_pagination is a switche to turn on pagination.
 *
 * @return array $katb_tdata_array testimonials and count
 */
function katb_get_testimonials( $group, $number, $by, $rotate, $use_pagination ) {
	global $wpdb , $tablename, $katb_options;
	$tablename        = $wpdb->prefix . 'testimonial_basics';
	$katb_tdata_array = array();
	if ( 'all' === $group && 'all' === $number && 'date' === $by ) {
		if ( isset( $use_pagination ) && true === $use_pagination && 'no' === $rotate ) {
			// Setup Pagination.
			// Get Pagination items per page.
			$katb_items_per_page = intval( $katb_options['katb_paginate_number'] );
			// Get total entries.
			$results       = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = %s", '1' ), ARRAY_A );// phpcs:ignore
			$total_entries = $results[0]['COUNT(1)'];
			// Check for offset.
			if ( isset( $_POST['ka_paginate_post'], $_POST['katb_paginate_form_nonce'] ) &&
			wp_verify_nonce( sanitize_key( $_POST['katb_paginate_form_nonce'] ), 'katb_paginate_nonce' ) ) {
				$ka_paginate_action = sanitize_text_field( wp_unslash( $_POST['ka_paginate_post'] ) );// phpcs:ignore
				katb_offset_setup( $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			// Pagination.
			$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
			$katb_offset         = $katb_paginate_setup['offset'];
			if ( 0 > $katb_offset ) {
				$katb_offset = 0; }
			// Get results.
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset", '1' ), ARRAY_A );// phpcs:ignore
		} else {
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_date` DESC", '1' ), ARRAY_A );// phpcs:ignore
		}
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' === $group && 'all' === $number && 'order' === $by ) {
		if ( isset( $use_pagination ) && true === $use_pagination && 'no' === $rotate ) {
			// Setup Pagination.
			// Get Pagination items per page.
			$katb_items_per_page = intval( $katb_options['katb_paginate_number'] );
			// Get total entries.
			$results       = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = %s", '1' ), ARRAY_A );// phpcs:ignore
			$total_entries = $results[0]['COUNT(1)'];
			// check for offset.
			if ( isset( $_POST['ka_paginate_post'], $_POST['katb_paginate_form_nonce'] ) &&
			wp_verify_nonce( sanitize_key( $_POST['katb_paginate_form_nonce'] ), 'katb_paginate_nonce' ) ) {
				$ka_paginate_action = sanitize_text_field( wp_unslash( $_POST['ka_paginate_post'] ) );// phpcs:ignore
				katb_offset_setup( $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			// Pagination.
			$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
			$katb_offset         = $katb_paginate_setup['offset'];
			if ( 0 > $katb_offset ) {
				$katb_offset = 0; }
			// Get results.
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_order` = %s, `tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset", '1', '0' ), ARRAY_A );// phpcs:ignore
		} else {
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_order` = %s, `tb_order` ASC,`tb_date` DESC", '1', '0' ), ARRAY_A );// phpcs:ignore
		}
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' === $group && 'all' === $number && 'random' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY RAND()", '1' ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' === $group && 'all' !== $number && 'date' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_date` DESC LIMIT 0,$number", '1' ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' === $group && 'all' !== $number && 'order' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY `tb_order` = %s,`tb_order` ASC LIMIT 0,$number", '1', '0' ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' === $group && 'all' !== $number && 'random' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s ORDER BY RAND() LIMIT 0,$number", '1' ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' === $number && 'date' === $by ) {
		if ( isset( $use_pagination ) && true === $use_pagination && 'no' === $rotate ) {
			// Setup Pagination.
			// Get Pagination items per page.
			$katb_items_per_page = intval( $katb_options['katb_paginate_number'] );
			// Get total entries.
			$results       = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s", '1', $group ), ARRAY_A );// phpcs:ignore
			$total_entries = $results[0]['COUNT(1)'];
			// Check for offset.
			if ( isset( $_POST['ka_paginate_post'], $_POST['katb_paginate_form_nonce'] ) &&
			wp_verify_nonce( sanitize_key( $_POST['katb_paginate_form_nonce'] ), 'katb_paginate_nonce' ) ) {
				$ka_paginate_action = sanitize_text_field( wp_unslash( $_POST['ka_paginate_post'] ) );// phpcs:ignore
				katb_offset_setup( $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			// Pagination.
			$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
			$katb_offset         = $katb_paginate_setup['offset'];
			if ( $katb_offset < 0 ) {
				$katb_offset = 0; }
			// Get results.
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset", '1', $group ), ARRAY_A );// phpcs:ignore
		} else {
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_date` DESC", '1', $group ), ARRAY_A );// phpcs:ignore
		}
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' === $number && 'order' === $by ) {
		if ( isset( $use_pagination ) && true === $use_pagination && 'no' === $rotate ) {
			// Setup Pagination.
			// Get Pagination items per page.
			$katb_items_per_page = intval( $katb_options['katb_paginate_number'] );
			// Get total entries.
			$results       = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s", '1', $group ), ARRAY_A );// phpcs:ignore
			$total_entries = $results[0]['COUNT(1)'];
			// Check for offset.
			if ( isset( $_POST['ka_paginate_post'], $_POST['katb_paginate_form_nonce'] ) &&
			wp_verify_nonce( sanitize_key( $_POST['katb_paginate_form_nonce'] ), 'katb_paginate_nonce' ) ) {
				$ka_paginate_action = sanitize_text_field( wp_unslash( $_POST['ka_paginate_post'] ) );// phpcs:ignore
				katb_offset_setup( $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			// Pagination.
			$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
			$katb_offset         = $katb_paginate_setup['offset'];
			if ( 0 > $katb_offset ) {
				$katb_offset = 0; }
			// Get results.
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset", '1', $group ), ARRAY_A );// phpcs:ignore
		} else {
			$katb_tdata = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC", '1', $group ), ARRAY_A );// phpcs:ignore
		}
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' === $number && 'random' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY RAND()", '1', $group ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' !== $number && 'date' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_date` DESC LIMIT 0,$number", '1', $group ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' !== $number && 'order' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number", '1', $group ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( 'all' !== $group && 'all' !== $number && 'random' === $by ) {
		$katb_tdata   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_approved` = %s AND `tb_group` = %s ORDER BY RAND() LIMIT 0,$number", '1', $group ), ARRAY_A );// phpcs:ignore
		$katb_tnumber = $wpdb->num_rows;
	}
	$katb_tdata_array[0] = $katb_tdata;
	$katb_tdata_array[1] = $katb_tnumber;
	if ( isset( $katb_paginate_setup ) ) {
		$katb_tdata_array[2] = $katb_paginate_setup;
	}
	return $katb_tdata_array;
}

/*
 * =====================================================================================================
 *                           Page Navigation Functions
 * ====================================================================================================
 */

/**
 * This function sets up the array $setup for use by the katb_display_pagination() function
 *
 * @param integer $span number of entries to display on each page.
 * @param string  $total_entries total number of testimonials.
 *
 * @return $setup : array, contains the setup variables passed to  katb_display_pagination()
 * set_transient( 'katb_pass_phrase_' . $form_id, SHA1( sanitize_text_field( $pass_phrase ) ), 1 * HOUR_IN_SECONDS );
 * get_transient( 'katb_pass_phrase_content' . $katb_input_form_no ) !== sha1( $katb_captcha_entered )
 */
function katb_setup_pagination( $span, $total_entries ) {
	$paginate_setup = array();
	// Prevent divide by 0.
	if ( '' === $span || 0 === $span ) {
		$span = 10; }
	// Check for offset and set to 0 if not there.
	if ( false !== get_transient( 'katb_paginate_offset' ) ) {
		$offset = esc_html( get_transient( 'katb_paginate_offset' ) );
	} else {
		$offset = 0;
	}
	// Calculate display pages required given the span.
	$pages_decimal = $total_entries / $span;
	$pages         = ceil( $pages_decimal );
	// Calculate the page selected based on the offset.
	$page_selected = intval( $offset / $span + 1 );
	// Safety Checks.
	if ( $page_selected > $pages ) {
		$offset = 0;
		set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) {
		$page_selected = 1;
	}
	// Figure out the pages to list.
	$max_page_buttons = 5;
	// Figure out $page_a.
	$j = $max_page_buttons;
	while ( $page_selected > $j ) {
		$j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	// Set up display configuration.
	// Only display the first button if there are a lot of downloads.
	if ( $pages > $max_page_buttons * 2 ) {
		$first = 'yes';
	} else {
		$first = 'no';
	}
	// Only display the previous button if more than 1 set.
	if ( $pages > $max_page_buttons ) {
		$previous = 'yes';
	} else {
		$previous = 'no';
	}
	// Set up remaining page buttons.
	if ( $page_a + 1 < $pages + 1 ) {
		$page_b = $page_a + 1;
	} else {
		$page_b = 'no';
	}
	if ( $page_a + 2 < $pages + 1 ) {
		$page_c = $page_a + 2;
	} else {
		$page_c = 'no';
	}
	if ( $page_a + 3 < $pages + 1 ) {
		$page_d = $page_a + 3;
	} else {
		$page_d = 'no';
	}
	if ( $page_a + 4 < $pages + 1 ) {
		$page_e = $page_a + 4;
	} else {
		$page_e = 'no';
	}
	// Only display middle button for large number of downloads.
	if ( $pages > $max_page_buttons * 2 ) {
		$middle = 'yes';
	} else {
		$middle = 'no';
	}
	// Only display the next button if more than 1 set.
	if ( $pages > $max_page_buttons ) {
		$next = 'yes';
	} else {
		$next = 'no';
	}
	// Only display the last button if there are a lot of downloads.
	if ( $pages > $max_page_buttons * 2 ) {
		$last = 'yes';
	} else {
		$last = 'no';
	}
	$setup = array(
		'offset'        => $offset,
		'pages'         => $pages,
		'page_selected' => $page_selected,
		'first'         => $first,
		'previous'      => $previous,
		'page_a'        => $page_a,
		'page_b'        => $page_b,
		'page_c'        => $page_c,
		'page_d'        => $page_d,
		'page_e'        => $page_e,
		'middle'        => $middle,
		'next'          => $next,
		'last'          => $last,
	);
	return $setup;
}

/**
 * This function displays the pagination buttons.
 * It is used by katb_testimonial_basics_edit_page() in katb_testimonial_basics_admin.php,
 * to provide pagination in the Edit Testimonials panel
 *
 * @param array $setup array : supplied by katb_setup_pagination().
 */
function katb_display_pagination( $setup ) {
	if ( $setup['pages'] > 1 ) {
		echo '<form class="katb-pagination" method="POST">';
		echo '<input type="button" class="ka_pages" value="Page ' . esc_attr( $setup['page_selected'] ) . ' / ' . esc_attr( $setup['pages'] ) . '">';
		if ( 'no' !== $setup['first'] ) {
			echo '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_paginate" />';
		}
		if ( 'no' !== $setup['previous'] ) {
			echo '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_paginate" />';
		}
		if ( $setup['page_a'] === $setup['page_selected'] ) {
			echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_a'] ) . '" class="ka_paginate_selected"  />';
		} else {
			echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_a'] ) . '" class="ka_paginate"  />';
		}
		if ( $setup['page_b'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_b'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_b'] ) . '" class="ka_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_b'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_b'] ) . '" class="ka_paginate" />';
			}
		}
		if ( $setup['page_c'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_c'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_c'] ) . '" class="ka_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_c'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_c'] ) . '" class="ka_paginate" />';
			}
		}
		if ( $setup['page_d'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_d'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_d'] ) . '" class="ka_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_d'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_d'] ) . '" class="ka_paginate" />';
			}
		}
		if ( $setup['page_e'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_e'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_e'] ) . '" class="ka_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_e'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_e'] ) . '" class="ka_paginate" />';
			}
		}
		if ( 'no' !== $setup['middle'] ) {
			echo '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_paginate" />';
		}
		if ( 'no' !== $setup['next'] ) {
			echo '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_paginate" />';
		}
		if ( 'no' !== $setup['last'] ) {
			echo '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_paginate" />';
		}
		wp_nonce_field( 'katb_paginate_nonce', 'katb_paginate_form_nonce', false, true );
		echo '</form>';
	}
}

/**
 * This function sets up the displays the pagination buttons html in a string.
 * It is called by katb_list_testimonials() in katb_shortcodes.php
 *
 * @param array   $setup array : supplied by katb_setup_pagination().
 * @param boolean $use_formatted_display switch for custom formats.
 *
 * @return $html_return - the return string to display the pagination
 */
function katb_get_display_pagination_string( $setup, $use_formatted_display ) {
	if ( true === $use_formatted_display ) {
		$format = ' format';
	} else {
		$format = '';
	}
	$html_return = '';
	if ( 1 < $setup['pages'] ) {
		$html_return .= '<form method="POST" class="katb_paginate' . esc_attr( $format ) . '">';
		$html_return .= '<input type="button" class="ka_display_paginate_summary" value="Page ' . esc_attr( $setup['page_selected'] ) . ' / ' . esc_attr( $setup['pages'] ) . '">';
		if ( 'no' !== $setup['first'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_display_paginate" />';
		}
		if ( 'no' !== $setup['previous'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_display_paginate" />';
		}
		if ( $setup['page_a'] === $setup['page_selected'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_a'] ) . '" class="ka_display_paginate_selected"  />';
		} else {
			$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_a'] ) . '" class="ka_display_paginate"  />';
		}
		if ( $setup['page_b'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_b'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_b'] ) . '" class="ka_display_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_b'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_b'] ) . '" class="ka_display_paginate" />';
			}
		}
		if ( $setup['page_c'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_c'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_c'] ) . '" class="ka_display_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_c'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_c'] ) . '" class="ka_display_paginate" />';
			}
		}
		if ( $setup['page_d'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_d'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_d'] ) . '" class="ka_display_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_d'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_d'] ) . '" class="ka_display_paginate" />';
			}
		}
		if ( $setup['page_e'] === $setup['page_selected'] ) {
			if ( 'no' !== $setup['page_e'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_e'] ) . '" class="ka_display_paginate_selected" />';
			}
		} else {
			if ( 'no' !== $setup['page_e'] ) {
				$html_return .= '<input type="submit" name="ka_paginate_post" value="' . esc_attr( $setup['page_e'] ) . '" class="ka_display_paginate" />';
			}
		}
		if ( 'no' !== $setup['middle'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_display_paginate" />';
		}
		if ( 'no' !== $setup['next'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_display_paginate" />';
		}
		if ( 'no' !== $setup['last'] ) {
			$html_return .= '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_display_paginate" />';
		}
		$html_return .= wp_nonce_field( 'katb_paginate_nonce', 'katb_paginate_form_nonce', false, false );
		$html_return .= '</form>';
	}
	return $html_return;
}

/**
 * This function sets up the offset depending which pagination button is clicked
 * Note : $offset is the last testimonial in the previous page and it is stored in
 * a WordPress transient. It is the variable used to determine where the pagination is at.
 *
 * @param integer $span number of entries to display on each page.
 * @param string  $action the value of the button that was clicked.
 * @param string  $total_entries total number of testimonials.
 */
function katb_offset_setup( $span, $action, $total_entries ) {
	// Start by getting offset.
	if ( false === get_transient( 'katb_paginate_offset' ) ) {
		$offset = intval( get_transient( 'katb_paginate_offset' ) );
	} else {
		$offset = 0;
	}
	// Prevent divide by 0.
	if ( '' === $span || 0 === $span ) {
		$span = 10;
	}
	// Calculate total pages.
	$pages_decimal = $total_entries / $span;
	$pages         = ceil( $pages_decimal );
	$page_selected = ( $offset / $span + 1 );
	// Safety Checks.
	if ( $page_selected > $pages ) {
		$offset = 0;
		set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
		$page_selected = 1;
	}
	if ( 1 > $page_selected ) {
		$page_selected = 1;
	}
	$max_page_buttons = 5;
	// Figure out $page_a.
	$j = 5;
	while ( $page_selected > $j ) {
		$j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	// Now that we know where we are at, figure out where we are going :).
	if ( '<<' === $action ) {
		set_transient( 'katb_paginate_offset', 0, 1 * HOUR_IN_SECONDS );
	} elseif ( '<' === $action ) {
		if ( 1 > $page_a - $max_page_buttons ) {
			set_transient( 'katb_paginate_offset', 0, 1 * HOUR_IN_SECONDS );
		} else {
			$offset = ( $page_a - $max_page_buttons - 1 ) * $span;
			set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
		}
	} elseif ( '^' === $action ) {
		$offset = ( floor( $pages / 2 ) - 1 ) * $span;
		set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
	} elseif ( '>' === $action ) {
		if ( $page_a + $max_page_buttons <= $pages ) {
			$offset = ( $page_a + $max_page_buttons - 1 ) * $span;
			set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
		}
	} elseif ( '>>' === $action ) {
		$offset = ( $pages - 1 ) * $span;
		set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
	} else {
		$page_no = intval( $action );
		$offset  = ( $page_no - 1 ) * $span;
		set_transient( 'katb_paginate_offset', $offset, 1 * HOUR_IN_SECONDS );
	}
}

/*
 * =================================================================================================
 *              Style Functions
 * =================================================================================================
 */
/**
 * This function provides the html for the css rating system
 *
 * @param string $rating is the rating.
 *
 * @return $rating html string
 */
function katb_css_rating( $rating ) {
	$fullstar   = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
<path d="M16 6.204l-5.528-0.803-2.472-5.009-2.472 5.009-5.528 0.803 4 3.899-0.944 5.505 4.944-2.599 4.944 2.599-0.944-5.505 4-3.899z"></path>
</svg>';
	$emptystar  = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
<path d="M16 6.204l-5.528-0.803-2.472-5.009-2.472 5.009-5.528 0.803 4 3.899-0.944 5.505 4.944-2.599 4.944 2.599-0.944-5.505 4-3.899zM8 11.773l-3.492 1.836 0.667-3.888-2.825-2.753 3.904-0.567 1.746-3.537 1.746 3.537 3.904 0.567-2.825 2.753 0.667 3.888-3.492-1.836z"></path>
</svg>';
	$halfstar   = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
<path d="M16 6.204l-5.528-0.803-2.472-5.009-2.472 5.009-5.528 0.803 4 3.899-0.944 5.505 4.944-2.599 4.944 2.599-0.944-5.505 4-3.899zM8 11.773l-0.015 0.008 0.015-8.918 1.746 3.537 3.904 0.567-2.825 2.753 0.667 3.888-3.492-1.836z"></path>
</svg>';
	$css_rating = '';
	switch ( $rating ) {
		case 0.0:
			$css_rating .= '<span class="katb-star 1">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 0.5:
			$css_rating .= '<span class="katb-star 1">' . $halfstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 1.0:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 1.5:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $halfstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 2.0:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 2.5:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $halfstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 3.0:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $emptystar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 3.5:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $halfstar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 4.0:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $emptystar . '</span>';
			break;
		case 4.5:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $halfstar . '</span>';
			break;
		case 5.0:
			$css_rating .= '<span class="katb-star 1">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 2">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 3">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 4">' . $fullstar . '</span>';
			$css_rating .= '<span class="katb-star 5">' . $fullstar . '</span>';
			break;
	}
	return $css_rating;
}

/**
 * This function hex colors to rgba colors.
 *
 * @param string $hex is the hex color string.
 *
 * @return $rgb is the array with trhe rgb values
 */
function katb_hex_to_rgba( $hex ) {
	$hex = str_replace( '#', '', $hex );
	if ( 3 === strlen( $hex ) ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
	return $rgb; // returns an array with the rgb values.
}

/**
 * Add custom styles.
 */
function katb_custom_css() {
	$katb_options                 = katb_get_options();
	$use_formatted_display        = $katb_options['katb_use_formatted_display'];
	$use_formatted_display_widget = $katb_options['katb_widget_use_formatted_display'];
	$katb_css                     = '';
	$katb_css                    .= '/* ==== Testimonial Basics Custom Styles  ==== */';
	// Content Custom Styles.
	if ( true === $katb_options['katb_use_italic_style'] ) {
		$katb_css .= '.katb_test_box .katb_test_text,.katb_test_box_basic .katb_test_text_basic,';
		$katb_css .= '.katb_right_box .katb_test_text,.katb_right_box .katb_test_text_basic';
		$katb_css .= '{font-style: italic;}';
	}
	$katb_css .= '.katb_test_box,.katb_test_box_basic,';
	$katb_css .= '.katb_test_box_side_meta,.katb_test_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box_basic,.katb_schema_summary_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box,.katb_schema_summary_box_side_meta,';
	$katb_css .= '.katb_paginate';
	$katb_css .= '{ font-size: ' . esc_html( $katb_options['katb_content_font_size'] ) . '; }';
	// Font.
	if ( 'default font' !== $katb_options['katb_content_font'] ) {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,.katb_paginate *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_schema_summary_wrap_basic *,';
		$katb_css .= '.katb_schema_summary_wrap_side_meta *,.katb_schema_summary_wrap_basic_side_meta *,';
		$katb_css .= '.katb_grid_wrap *,.katb_grid_wrap_basic *';
		$katb_css .= '{ font-family: ' . sanitize_text_field( $katb_options['katb_content_font'] ) . ';}';
	} else {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,.katb_paginate *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_schema_summary_wrap_basic *,';
		$katb_css .= '.katb_schema_summary_wrap_side_meta *,.katb_schema_summary_wrap_basic_side_meta *,';
		$katb_css .= '.katb_grid_wrap *,.katb_grid_wrap_basic *';
		$katb_css .= '{ font-family: inherit; }';
	}
	// Font color.
	$katb_css .= '.katb_test_wrap,.katb_schema_summary_wrap,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_left_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_schema_company_wrap_side_meta';
	$katb_css .= '{ background-color: ' . esc_html( $katb_options['katb_background_wrap_color'] ) . ';';
	$katb_css .= 'color: ' . esc_html( $katb_options['katb_testimonial_box_font_color'] ) . ';}';
	// Font Color.
	$katb_css .= '.katb_test_wrap .katb_test_box,.katb_schema_summary_box,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_right_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_aggregate_wrap_side_meta,';
	$katb_css .= '.katb_test_wrap .katb_test_text *';
	$katb_css .= '{background-color: ' . esc_html( $katb_options['katb_testimonial_box_color'] ) . ';';
	$katb_css .= 'color: ' . esc_html( $katb_options['katb_testimonial_box_font_color'] ) . '!important; }';
	// author,location, and date custom colors.
	$katb_css .= '.katb_test_box .katb_author,.katb_test_box_side_meta .katb_author,';
	$katb_css .= '.katb_test_box .katb_date,.katb_test_box_side_meta .katb_date,';
	$katb_css .= '.katb_test_box .katb_location,.katb_test_box_side_meta .katb_location,';
	$katb_css .= '.katb_test_box .katb_custom1,.katb_test_box_side_meta .katb_custom1,';
	$katb_css .= '.katb_test_box .katb_custom2,.katb_test_box_side_meta .katb_custom2';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_author_location_color'] ) . '!important; }';
	// link colors.
	$katb_css .= '.katb_test_box a,.katb_schema_summary_box a,.katb_test_box_side_meta a,';
	$katb_css .= '.katb_schema_summary_box_side_meta a,.katb_test_box .katb_test_text .katb_excerpt_more,';
	$katb_css .= '.katb_bulk_delete_label a';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_website_link_color'] ) . '!important;}';
	// link hover colors.
	$katb_css .= '.katb_test_box a:hover,.katb_schema_summary_box a:hover ,.katb_test_box_side_meta a:hover,';
	$katb_css .= '.katb_schema_summary_box_side_meta a:hover,.katb_test_box .katb_test_text .katb_excerpt_more:hover,';
	$katb_css .= '.katb_bulk_delete_label a:hover';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_website_link_hover_color'] ) . '!important; }';
	// Pagination colors.
	$katb_css .= '.katb_paginate.format input {';
	$katb_css .= 'background-color: ' . esc_html( $katb_options['katb_testimonial_box_color'] ) . '!important;';
	$katb_css .= 'color: ' . esc_html( $katb_options['katb_author_location_color'] ) . '!important;}';
	// Content font size.
	$katb_css .= '.katb_paginate input {';
	$katb_css .= 'font-size: ' . esc_html( $katb_options['katb_content_font_size'] ) . '!important; }';
	// Input font size.
	$katb_css .= '.katb_input_style ';
	$katb_css .= '{font-size: ' . esc_html( $katb_options['katb_content_input_font_size'] ) . '!important; }';
	// Grid custom styles.
	$katb_css .= '.katb_grid_wrap .katb_two_wrap_all {';
	$katb_css .= 'border: 1px solid ' . esc_html( $katb_options['katb_testimonial_box_color'] ) . '!important;}';
	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_meta_bottom';
	$katb_css .= '{ background-color: ' . esc_html( $katb_options['katb_testimonial_box_color'] ) . '!important;}';
	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_test_text';
	$katb_css .= '{ background-color: ' . esc_html( $katb_options['katb_background_wrap_color'] ) . '!important;}';
	// Widget Display Custom Styles.
	if ( true === $katb_options['katb_widget_use_italic_style'] ) {
		$katb_css .= '.katb_widget_box .katb_test_text,.katb_widget_box_basic .katb_test_text_basic,';
		$katb_css .= '.katb_widget_rotator_box .katb_testimonial_wrap,.katb_widget_rotator_box_basic .katb_testimonial_wrap';
		$katb_css .= '{font-style: italic;}';
	}
	// Font size.
	$katb_css .= '.katb_widget_box,.katb_widget_box_basic,';
	$katb_css .= '.katb_widget_rotator_box,.katb_widget_rotator_box_basic';
	$katb_css .= '{ font-size: ' . esc_html( $katb_options['katb_widget_font_size'] ) . ' }';
	// Font type.
	if ( 'default font' !== $katb_options['katb_widget_font'] ) {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: ' . sanitize_text_field( $katb_options['katb_widget_font'] ) . '; }';
	} else {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: inherit; }';
	}
	// Background color.
	$katb_css .= '.katb_widget_rotator_wrap,.katb_widget_box {';
	$katb_css .= 'background-color: ' . esc_html( $katb_options['katb_widget_background_color'] ) . '; }';
	// Font color.
	$katb_css .= '.katb_widget_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_widget_box .katb_testimonial_wrap *,';
	$katb_css .= '.katb_widget_rotator_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_widget_rotator_box .katb_testimonial_wrap';
	$katb_css .= '{	color: ' . esc_html( $katb_options['katb_widget_font_color'] ) . '!important;}';
	// Meta.
	$katb_css .= '.katb_widget_box .widget_meta,.katb_widget_rotator_box .widget_meta';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_widget_author_location_color'] ) . ';}';
	// Link.
	$katb_css .= '.katb_widget_box a,.katb_widget_rotator_box a,';
	$katb_css .= '.katb_widget_box a.katb_excerpt_more,.katb_widget_rotator_box a.katb_excerpt_more';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_widget_website_link_color'] ) . '!important;}';
	// Link hover.
	$katb_css .= '.katb_widget_box a:hover,.katb_widget_rotator_box a:hover ';
	$katb_css .= '{color: ' . esc_html( $katb_options['katb_widget_website_link_hover_color'] ) . '!important;}';
	// Divider.
	$katb_css .= '.katb_widget_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_bottom';
	$katb_css .= '{ border-top: 1px solid ' . esc_html( $katb_options['katb_widget_divider_color'] ) . '; }';
	// Divider.
	$katb_css .= '.katb_widget_box .katb_title_rating_wrap.center,';
	$katb_css .= '.katb_widget_rotator_box .katb_title_rating_wrap.center';
	$katb_css .= '{ border-bottom: 1px solid ' . esc_html( $katb_options['katb_widget_divider_color'] ) . '; }';
	// Divider.
	$katb_css .= '.katb_widget_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_top';
	$katb_css .= '{border-bottom: 1px solid ' . esc_html( $katb_options['katb_widget_divider_color'] ) . '; }';
	// * Widget Input Form.
	$katb_css .= '.katb_widget_form {';
	$katb_css .= 'font-size: ' . esc_html( $katb_options['katb_widget_input_font_size'] ) . '!important; }';
	// Other Custom Styles.
	// Star color.
	$katb_css .= '.katb_css_rating { ';
	$katb_css .= 'color: ' . esc_html( $katb_options['katb_star_color'] ) . '!important; }';
	// Remove testimonial link.
	$katb_css .= '.katb_remove_link.remove_link_content a svg {';
	$katb_css .= 'width:' . esc_html( $katb_options['katb_content_font_size'] ) . '; }';
	$katb_css .= '.katb_remove_link.remove_link_widget a svg {';
	$katb_css .= 'width:' . esc_html( $katb_options['katb_widget_font_size'] ) . '; }';
	// escape.
	$katb_css .= wp_filter_nohtml_kses( $katb_options['katb_custom_css'] );
	return $katb_css;
}

/*
 * ======================================================================================================
 *              Email Functions
 * ======================================================================================================
 */

/**
 * This function sends the email notification after the testimonial has been input
 *
 * @param string $author name of author.
 * @param string $author_email author's email address.
 * @param string $testimonial html testimonial string.
 */
function katb_email_notification( $author, $author_email, $testimonial ) {
	global $katb_options;
	// Add filter to use html in contact area.
	add_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
	// Get email address.
	if ( isset( $katb_options['katb_contact_email'] ) && '' !== $katb_options['katb_contact_email'] ) {
		$emailto = is_email( $katb_options['katb_contact_email'] );
	} else {
		$emailto = is_email( get_option( 'admin_email' ) );
	}
	$subject_trans = esc_html__( 'You have received a testimonial!', 'testimonial-basics' );
	$subject       = $subject_trans;
	$body_trans    = esc_html__( 'Name: ', 'testimonial-basics' ) . ' ' . esc_html( $author ) . '<br/><br/>'
					. esc_html__( 'Email: ', 'testimonial-basics' ) . ' ' . is_email( $author_email ) . '<br/><br/>'
					. esc_html__( 'Comments: ', 'testimonial-basics' ) . '<br/><br/>'
					. wp_kses_post( $testimonial ) . '<br/><br/>'
					. esc_html__( 'Log in to approve or view it.', 'testimonial-basics' );
	$body          = $body_trans;
	$headers_trans = esc_html__( 'From: ', 'testimonial-basics' ) . esc_html( $author ) . ' <' . is_email( $author_email ) . '>';
	$headers       = $headers_trans;
	// Send email.
	wp_mail( $emailto, $subject, $body, $headers );
	// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578.
	remove_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
}

/**
 * This function sends the email request to remove a testimonial
 *
 * @param string $katb_remover_email remover's email address.
 * @param string $katb_remover_reason reason for removing testimonial.
 * @param array  $katb_tdata data for testimonial to be removed.
 */
function katb_remove_testimonial_request( $katb_remover_email, $katb_remover_reason, $katb_tdata ) {
	global $katb_options;
	$author_label      = $katb_options['katb_author_label'];
	$email_label       = $katb_options['katb_email_label'];
	$website_label     = $katb_options['katb_website_label'];
	$location_label    = $katb_options['katb_location_label'];
	$custom1_label     = $katb_options['katb_custom1_label'];
	$custom2_label     = $katb_options['katb_custom2_label'];
	$rating_label      = $katb_options['katb_rating_label'];
	$title_label       = $katb_options['katb_testimonial_title_label'];
	$testimonial_label = $katb_options['katb_testimonial_label'];
	// Add filter to use html in contact area.
	add_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
	// Get email address.
	if ( isset( $katb_options['katb_contact_email'] ) && '' !== $katb_options['katb_contact_email'] ) {
		$emailto = is_email( $katb_options['katb_contact_email'] );
	} else {
		$emailto = is_email( get_option( 'admin_email' ) );
	}
	if ( '' === trim( $katb_remover_reason ) ) {
		$katb_remover_reason = __( 'No reason was given.', 'testimonial-basics' );
	}
	$subject_trans = esc_html__( 'Request for Testimonial Removal!', 'testimonial-basics' );
	$subject       = $subject_trans;
	if ( false !== $katb_tdata ) {
		$date        = esc_html( $katb_tdata[0]['tb_date'] );
		$date_string = date_i18n( get_option( 'date_format' ), strtotime( $date ) );
		$body_trans  = esc_html__( 'Email: ', 'testimonial-basics' ) . ' ' . esc_html( $katb_remover_email ) . '<br/><br/>'
						. esc_html__( 'Reason: ', 'testimonial-basics' ) . '<br/><br/>'
						. esc_html( $katb_remover_reason ) . '<br/><br/>'
						. esc_html__( 'Testimonial to be removed:', 'testimonial-basics' ) . '<br/><br/>'
						. esc_html__( '=========================================', 'testimonial-basics' ) . '<br/><br/>'
						. esc_html__( 'Title: ', 'testimonial-basics' ) . esc_html( $katb_tdata[0]['tb_title'] ) . '<br/><br/>'
						. esc_html( $rating_label ) . esc_html( $katb_tdata[0]['tb_rating'] ) . '<br/><br/>'
						. esc_html( $author_label ) . esc_html( $katb_tdata[0]['tb_name'] ) . '<br/><br/>'
						. esc_html__( 'Date: ', 'testimonial-basics' ) . $date_string . '<br/><br/>'
						. esc_html( $location_label ) . esc_html( $katb_tdata[0]['tb_location'] ) . '<br/><br/>'
						. esc_html( $custom1_label ) . esc_html( $katb_tdata[0]['tb_custom1'] ) . '<br/><br/>'
						. esc_html( $custom1_label ) . esc_html( $katb_tdata[0]['tb_custom2'] ) . '<br/><br/>'
						. esc_html( $website_label ) . esc_html( $katb_tdata[0]['tb_url'] ) . '<br/><br/>'
						. esc_html( $testimonial_label ) . wp_kses_post( $katb_tdata[0]['tb_testimonial'] ) . '<br/><br/>';
		$body        = $body_trans;
	} else {
		$body_trans = esc_html__( 'Email: ', 'testimonial-basics' ) . ' ' . esc_html( $katb_remover_email ) . '<br/><br/>'
						. esc_html__( 'Reason: ', 'testimonial-basics' ) . '<br/><br/>'
						. esc_html( $katb_remover_reason ) . '<br/><br/>';
		$body       = $body_trans;
	}
	$headers_trans = esc_html__( 'From: ', 'testimonial-basics' ) . ' <' . esc_html( $katb_remover_email ) . '>';
	$headers       = $headers_trans;
	// Send email.
	wp_mail( $emailto, $subject, $body, $headers );
	// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578.
	remove_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
}

/**
 * This function sets up wp_mail() to use html
 */
function katb_wp_mail_content_type() {
	return 'text/html';
}

/*
 * ====================================================================================================
 *                     Captcha Functions
 * ====================================================================================================
 */

/**
 * This function sets up a black and white captcha for the input form,
 * returning a string of html for the captcha image
 *
 * @param string $form_source widget or content.
 * @param string $form_no the number of the form.
 */
function katb_bw_captcha( $form_source, $form_no ) {
	// Set some important CAPTCHA constants.
	$number_characters   = 6; // number of characters in pass-phrase.
	$captcha_height      = 26; // height of image.
	$image_return_string = '';
	// Generate the random pass-phrase.
	$pass_phrase = '';
	$characters  = 'abcdefghijklmnopqrstuvwxyz';
	for ( $i = 0; $i < $number_characters; $i++ ) {
		$position     = mt_rand( 0, strlen( $characters ) - 1 );// phpcs:ignore
		$pass_phrase .= $characters[ $position ];
	}
	$font_file_url = dirname( __FILE__ ) . '/Raleway-Medium.ttf';
	$textbox_size  = imagettfbbox( 16, 0, $font_file_url, $pass_phrase );
	$text_width    = $textbox_size[2] - $textbox_size[0];
	$captcha_width = $text_width + 10; // width of image.
	$form_id       = $form_source . $form_no;
	// Store the encrypted pass-phrase in a transient.
	set_transient( 'katb_pass_phrase_' . $form_id, SHA1( sanitize_text_field( $pass_phrase ) ), 1 * HOUR_IN_SECONDS );
	// Create the image.
	$katb_img = imagecreatetruecolor( $captcha_width, $captcha_height );
	// Set a white background with black text and gray graphics.
	$bg_color      = imagecolorallocate( $katb_img, 255, 255, 255 ); // white.
	$text_color    = imagecolorallocate( $katb_img, 0, 0, 0 ); // black.
	$graphic_color = imagecolorallocate( $katb_img, 64, 64, 64 ); // dark gray.
	// Fill the background.
	imagefilledrectangle( $katb_img, 0, 0, $captcha_width, $captcha_height, $bg_color );
	// Draw some random lines.
	for ( $i = 0; $i < 5; $i++ ) {
		imageline( $katb_img, 0, rand() % $captcha_height, $captcha_width, rand() % $captcha_height, $graphic_color );// phpcs:ignore
	}
	// Sprinkle in some random dots.
	for ( $i = 0; $i < 50; $i++ ) {
		imagesetpixel( $katb_img, rand() % $captcha_width, rand() % $captcha_height, $graphic_color );// phpcs:ignore
	}
	// Draw the pass-phrase string.
	imagettftext( $katb_img, 16, 0, 5, $captcha_height - 5, $text_color, $font_file_url, $pass_phrase );

	ob_start();
	imagepng( $katb_img );
	$contents = ob_get_contents();
	ob_end_clean();
	$string = 'data:image/png;base64,' . base64_encode( $contents ); // phpcs:ignore
	// Clean up.
	imagedestroy( $katb_img );
	$img_return_string = '<img src="' . $string . '" alt="Verification Captcha" />';
	return $img_return_string;
}

/**
 * This function sets up a color captcha for the input form,
 * returning a string of html for the captcha image
 *
 * @param string $form_source widget or content.
 * @param string $form_no the number of the form.
 */
function katb_color_captcha( $form_source, $form_no ) {
	// Set some important CAPTCHA constants.
	$number_characters   = 5; // number of characters in pass-phrase.
	$captcha_width       = 120; // width of image.
	$captcha_height      = 24; // height of image.
	$image_return_string = '';
	// Create the image.
	$katb_img = imagecreatetruecolor( $captcha_width, $captcha_height );
	// Generate the random pass-phrase.
	$pass_phrase = '';
	$characters  = 'abcdefghijklmnopqrstuvwxyz';
	$xpos        = 0;
	$ypos        = 0;
	for ( $i = 0; $i < $number_characters; $i++ ) {
		$position     = mt_rand( 0, strlen( $characters ) - 1 );// phpcs:ignore
		$pass_phrase .= $characters[ $position ];
		$letter_img   = imagecreatefrompng( dirname( __FILE__ ) . '/captcha_images/' . $characters[ $position ] . '.png' );
		imagecopy( $katb_img, $letter_img, $xpos, $ypos, 0, 0, 24, 24 );
		$xpos = $xpos + 24;
	}
	// Store the encrypted pass-phrase in a transient.
	$form_id = $form_source . $form_no;
	set_transient( 'katb_pass_phrase_' . $form_id, SHA1( sanitize_text_field( $pass_phrase ) ), 1 * HOUR_IN_SECONDS );
	ob_start();
	imagepng( $katb_img );
	$contents = ob_get_contents();
	ob_end_clean();
	$string = 'data:image/png;base64,' . base64_encode( $contents ); // phpcs:ignore
	// Clean up.
	imagedestroy( $letter_img );
	imagedestroy( $katb_img );
	$img_return_string = '<img src="' . $string . '" alt="Verification Captcha" />';
	return $img_return_string;
}

/**
 * This function provides the html and transient password for the color option 2 captcha
 *
 * @param string $form_source - either 'widget' or 'content.
 * @param string $form_no - if more than one widget form on a page they should have different form numbers.
 *
 * @return $return_html - html representing the captcha
 */
function katb_color_captcha_2( $form_source, $form_no ) {
	$katb_code_key    = array(
		'sIcv1CnLJ6k6',
		'63m1IUWRUjjn',
		'lajBgRjQblvW',
		'Ri0DDNEVbWDX',
		'xSoOfznHgmJp',
		'67WoNF2iAZHR',
		'XxgBqRl4fqXz',
		'YseePGIyWDiG',
		'rWviQrABe1Dj',
		'lnuVuHfVdjal',
		'dZORncMtSOAk',
		'Mg6Ey0TYNFAd',
		'7kLYp8Fp8PnZ',
		'PZfYWIoauaTL',
		'BBDS9jzpsbKG',
		'6UE09Ek8wVYf',
		'Gv4xHuDWPRfs',
		'w3H5BSWnLKpq',
		'KYfeiGkWJowT',
		'Hyt367nHpaL6',
		'4WDPNRqZdJS3',
		'zFi53Wz1l65c',
		'ENM15Ul1bpUh',
		'EQrxJi6CR8zF',
		'cBlPfQ5FaODL',
		'xPxckkMz2uQz',
	);
	$katb_captcha_key = array(
		'sIcv1CnLJ6k6' => 'a',
		'63m1IUWRUjjn' => 'b',
		'lajBgRjQblvW' => 'c',
		'Ri0DDNEVbWDX' => 'd',
		'xSoOfznHgmJp' => 'e',
		'67WoNF2iAZHR' => 'f',
		'XxgBqRl4fqXz' => 'g',
		'YseePGIyWDiG' => 'h',
		'rWviQrABe1Dj' => 'i',
		'lnuVuHfVdjal' => 'j',
		'dZORncMtSOAk' => 'k',
		'Mg6Ey0TYNFAd' => 'l',
		'7kLYp8Fp8PnZ' => 'm',
		'PZfYWIoauaTL' => 'n',
		'BBDS9jzpsbKG' => 'o',
		'6UE09Ek8wVYf' => 'p',
		'Gv4xHuDWPRfs' => 'q',
		'w3H5BSWnLKpq' => 'r',
		'KYfeiGkWJowT' => 's',
		'Hyt367nHpaL6' => 't',
		'4WDPNRqZdJS3' => 'u',
		'zFi53Wz1l65c' => 'v',
		'ENM15Ul1bpUh' => 'w',
		'EQrxJi6CR8zF' => 'x',
		'cBlPfQ5FaODL' => 'y',
		'xPxckkMz2uQz' => 'z',
	);
	$pass_phrase      = '';
	$return_html      = '';
	shuffle( $katb_code_key );
	for ( $i = 0; $i < 5; $i++ ) {
		$pass_phrase .= $katb_captcha_key[ $katb_code_key[ $i ] ];
		$return_html .= '<img class="single-letter" src="' . plugin_dir_url( __FILE__ ) . 'captcha_images/' . $katb_code_key[ $i ] . '.png" alt="captcha" />';
	}
	// Store the encrypted pass-phrase in a transient.
	$form_id = $form_source . $form_no;
	set_transient( 'katb_pass_phrase_' . $form_id, SHA1( sanitize_text_field( $pass_phrase ) ), 1 * HOUR_IN_SECONDS );
	return $return_html;
}

/**
 * Add async to reCaptcha enqueue_script()
 *
 * @param string $tag is the script returned if not google-recaptcha.
 * @param string $handle is the enqueue_scritp handle.
 * @param string $src is the url where the script is.
 */
function katb_recaptcha_tag( $tag, $handle, $src ) {
	if ( 'google-recaptcha' !== $handle ) {
		return $tag;
	}
	return "<script type=\"text/javascript\" src='$src' async></script>"; // phpcs:ignore
}
add_filter( 'script_loader_tag', 'katb_recaptcha_tag', 10, 3 );

/*
 * =============================================================================================
 *              Display/Input in code
 * =============================================================================================
 */

/**
 * Display Testimonial in code.
 *
 * This function allows you to use display testimonials in code
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database.
 * @param string $number : all or a number.
 * @param string $by : order or date or random.
 * @param string $id : blank or id's of the testimonial separated by a comma.
 * @param string $rotate : 'yes' or 'no' used to rotate testimonials.
 * @param string $layout : '0','1','2','3','4','5', or '6'.
 * @param string $schema : 'default','yes', or 'no'.
 *
 * @uses katb_list_testimonials ( $atts ) in katb_shortcodes.php
 */
function katb_testimonial_basics_display_in_code( $group = 'all', $number = 'all', $by = 'random', $id = '', $rotate = 'no', $layout = '0', $schema = 'default' ) {

	$group  = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ) );
	$by     = strtolower( sanitize_text_field( $by ) );
	$id     = sanitize_text_field( $id );
	$rotate = strtolower( sanitize_text_field( $rotate ) );
	$layout = sanitize_text_field( $layout );
	$schema = sanitize_text_field( $schema );

	// whitelist rotate.
	if ( 'yes' !== $rotate ) {
		$rotate = 'no';
	}
	// white list group.
	if ( '' === $group || 'All' === $group ) {
		$group = 'all';
	}
	// number validation/whitelist.
	if ( '' === $number || 'All' === $number ) {
		$number = 'all'; }
	if ( 'all' !== $number ) {
		if ( 1 > intval( $number ) ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	// Validate $by.
	if ( 'date' !== $by && 'order' !== $by ) {
		$by = 'random';
	}
	// white list layout.
	if ( '0' !== $layout && '1' !== $layout && '2' !== $layout && '3' !== $layout && '4' !== $layout && '5' !== $layout && '6' !== $layout ) {
		$layout = '0';
	}
	// white list schema.
	if ( 'yes' !== $schema && 'no' !== $schema ) {
		$schema = 'default';
	}
		$atts = array(
			'group'  => $group,
			'number' => $number,
			'by'     => $by,
			'id'     => $id,
			'rotate' => $rotate,
			'layout' => $layout,
			'schema' => $schema,
		);
	echo katb_list_testimonials( $atts ); // phpcs:ignore
}

/** Display Input form in code.
 *
 * This function allows you to set up the input testimonials form in code.
 * It accepts arguments just like in the shortcode and displays accordingly.
 *
 * @param string $group group used in database.
 * @param string $form is the form number on the page.
 *
 * @uses katb_display_input_form( $atts ) in katb_shortcodes.php
 */
function katb_testimonial_basics_input_in_code( $group = 'All', $form = '1' ) {
	$group = sanitize_text_field( $group );
	$form  = sanitize_text_field( $form );
	// white list group.
	if ( '' === $group || 'All' === $group || 'All' === $group ) {
		$group = 'all';
	}
	// validate form.
	if ( '' === $form ) {
		$form = '1';
	}
	$atts = array(
		'group' => $group,
		'form'  => $form,
	);
	echo katb_display_input_form( $atts );  // phpcs:ignore
}

/*
 * ====================================================================================
 *                Other Functions
 * ====================================================================================
 */

/**
 * Allowed HTML
 *
 * Supplies array of filter parameters for wp_kses($text,$allowed_html).
 * Only this html will be allowed in testimonials submitted by visitors
 * used in katb_check_for_submitted_testimonial()
 * and in katb_input_testimonial_widget.php function widget
 *
 * @return  array   $allowed_html
 */
function katb_allowed_html() {
	$allowed_html = array(
		'p'      => array(),
		'br'     => array(),
		'i'      => array(),
		'h1'     => array(),
		'h2'     => array(),
		'h3'     => array(),
		'h4'     => array(),
		'h5'     => array(),
		'h6'     => array(),
		'em'     => array(),
		'strong' => array(),
		'q'      => array(),
		'a'      => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
		),
	);
	return apply_filters( 'katb_allowed_html', $allowed_html );
}
