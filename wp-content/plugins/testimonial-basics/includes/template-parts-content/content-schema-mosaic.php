<?php
/**
 * This file is the layout code for displaying testimonials in the content area using
 * the shortcode. It uses no schema, mosaic layout and custom or basic formats.
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

?>
<div itemscope itemtype="http://schema.org/Organization">
	<?php
	global $katb_excerpt_required;
	// no schema switch.
	$use_schema = true;
	// source is required for setting up excerpts if they are being used.
	$source = 'content';
	// Get the schema html.
	echo katb_company_aggregate_display( $use_formatted_display, $group_name, 'Mosaic' ); // WPCS: XSS ok.
	if ( true === $display_reviews ) {
	?>
	<div class="katb_grid_wrap<?php echo esc_attr( $format ); ?>">
		<?php
		// prep popups.
		for ( $i = 0; $i < $katb_tnumber; $i++ ) {
			// check to see if a popup is required.
			$katb_is_popup_required = katb_popup_required( $length, $katb_tdata[ $i ]['tb_testimonial'] );
			// set up hidden popup if excerpt is used.
			if ( true === $use_excerpts && false !== $katb_is_popup_required ) {
				// get the gravatar or photo html.
				$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[ $i ]['tb_pic_url'], $gravatar_size, $use_gravatars, $use_round_images, $use_gravatar_substitute, $katb_tdata[ $i ]['tb_email'] );
				// set up the popup.
				katb_setup_popup( $i, $katb_tdata, $gravatar_or_photo, 'content' );
			}
		}
		?>
		<div class="katb_two_col_1">
			<?php
			$katb_count = 0;
			// Column 1.
			for ( $i = 0; $i < $katb_tnumber; $i++ ) {
				if ( 0 === $katb_count || is_int( $katb_count / 2 ) ) {
					// if gravatars are enabled, check for valid avatar.
					if ( true === $use_gravatars && false === $use_gravatar_substitute ) {
						$has_valid_avatar = katb_validate_gravatar( $katb_tdata[ $i ]['tb_email'] );
					} else {
						$has_valid_avatar = 0;
					}
					// get the gravatar or photo html.
					$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[ $i ]['tb_pic_url'], $gravatar_size, $use_gravatars, $use_round_images, $use_gravatar_substitute, $katb_tdata[ $i ]['tb_email'] );
					?>
					<div id="katb_col_1_<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>" class="katb_two_wrap_all katb_two_wrap_1" data-order="<?php echo esc_attr( $katb_count ); ?>" >
						<div class="katb_test_box<?php echo esc_attr( $format ); ?>" itemscope itemtype="http://schema.org/Review">
							<?php
							if ( true === $use_title || true === $use_ratings && '0.0' !== $katb_tdata[ $i ]['tb_rating'] && '' !== $katb_tdata[ $i ]['tb_rating'] ) {
								?>
								<div class="katb_title_rating_wrap">
								<?php
									katb_get_title_html( $use_title, $use_schema, $katb_tdata[ $i ]['tb_group'], $katb_tdata[ $i ]['tb_title'], $custom_title );
									katb_get_rating_html( $use_ratings, $use_schema, $katb_tdata[ $i ]['tb_rating'] );
								?>
								</div>
								<?php
							}
							?>
							<div class="katb_testimonial_wrap">
							<?php
								katb_get_content_html( $use_schema, $format, $use_excerpts, $length, $gravatar_or_photo, $katb_tdata[ $i ]['tb_testimonial'], $katb_tdata[ $i ]['tb_id'], $source );
							?>
							</div>
							<div class="katb_meta_bottom">
							<?php
								$divider = '&nbsp;&nbsp;';
								katb_get_author_html( $use_schema, $katb_tdata[ $i ]['tb_name'], $divider );
								katb_get_date_html( $use_schema, $katb_options['katb_show_date'], $katb_tdata[ $i ]['tb_date'], $divider );
								katb_get_location_html( $katb_options['katb_show_location'], $katb_tdata[ $i ]['tb_location'], $divider );
								katb_get_custom1_html( $katb_options['katb_show_custom1'], $katb_tdata[ $i ]['tb_custom1'], $divider );
								katb_get_custom2_html( $katb_options['katb_show_custom2'], $katb_tdata[ $i ]['tb_custom2'], $divider );
								katb_get_website_html( $katb_options['katb_show_website'], $katb_tdata[ $i ]['tb_url'], $divider );
								katb_get_gdpr_link( $gdpr_remove_permalink, $katb_tdata[ $i ]['tb_id'], $divider, 'remove_link_content' );
							?>
							</div>
						</div>
					</div>
					<?php
				}
				$katb_count++;
			}
			?>
			</div>
				<div class="katb_two_col_2">
					<?php
					// Column 2.
					$katb_count = 0;
					for ( $i = 0; $i < $katb_tnumber; $i++ ) {
						if ( 1 === $katb_count || is_int( ( $katb_count + 1 ) / 2 ) ) {
							// if gravatars are enabled, check for valid avatar.
							if ( true === $use_gravatars && false === $use_gravatar_substitute ) {
								$has_valid_avatar = katb_validate_gravatar( $katb_tdata[ $i ]['tb_email'] );
							} else {
								$has_valid_avatar = 0;
							}
							// get the gravatar or photo html.
							$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[ $i ]['tb_pic_url'], $gravatar_size, $use_gravatars, $use_round_images, $use_gravatar_substitute, $katb_tdata[ $i ]['tb_email'] );
							?>
							<div id="katb_col_2_<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>" class="katb_two_wrap_all katb_two_wrap_2" data-order="<?php echo esc_attr( $katb_count ); ?>" >
								<div class="katb_test_box<?php echo esc_attr( $format ); ?>" itemscope itemtype="http://schema.org/Review">
									<?php
									if ( true === $use_title || true === $use_ratings && '0.0' !== $katb_tdata[ $i ]['tb_rating'] && '' !== $katb_tdata[ $i ]['tb_rating'] ) {
										?>
										<div class="katb_title_rating_wrap">
											<?php
												katb_get_title_html( $use_title, $use_schema, $katb_tdata[ $i ]['tb_group'], $katb_tdata[ $i ]['tb_title'], $custom_title );
												katb_get_rating_html( $use_ratings, $use_schema, $katb_tdata[ $i ]['tb_rating'] );
											?>
										</div>
										<?php
									}
									?>
									<div class="katb_testimonial_wrap">
										<?php
										katb_get_content_html( $use_schema, $format, $use_excerpts, $length, $gravatar_or_photo, $katb_tdata[ $i ]['tb_testimonial'], $katb_tdata[ $i ]['tb_id'], $source );
										?>
									</div>
									<div class="katb_meta_bottom">
										<?php
										$divider = '&nbsp;&nbsp;';
										katb_get_author_html( $use_schema, $katb_tdata[ $i ]['tb_name'], $divider );
										katb_get_date_html( $use_schema, $katb_options['katb_show_date'], $katb_tdata[ $i ]['tb_date'], $divider );
										katb_get_location_html( $katb_options['katb_show_location'], $katb_tdata[ $i ]['tb_location'], $divider );
										katb_get_custom1_html( $katb_options['katb_show_custom1'], $katb_tdata[ $i ]['tb_custom1'], $divider );
										katb_get_custom2_html( $katb_options['katb_show_custom2'], $katb_tdata[ $i ]['tb_custom2'], $divider );
										katb_get_website_html( $katb_options['katb_show_website'], $katb_tdata[ $i ]['tb_url'], $divider );
										katb_get_gdpr_link( $gdpr_remove_permalink, $katb_tdata[ $i ]['tb_id'], $divider, 'remove_link_content' );
										?>
									</div>
								</div>
							</div>
							<?php
						}
						$katb_count ++;
					}
					?>
			</div>
		</div>
		<?php
	}
	?>
</div>
<div class="katb_clear_fix"></div>
