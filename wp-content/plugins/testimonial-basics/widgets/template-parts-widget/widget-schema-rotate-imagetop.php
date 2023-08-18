<?php
/**
 * This file is the layout code for displaying testimonials using the widget.
 * It uses schema, rotation, image and meta on top, and custom or basic formats.
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

?>
<div itemscope itemtype="http://schema.org/Organization">
	<?php katb_widget_schema_company_aggregate( $company_name, $company_website, $group_name, $use_aggregate_group_name, $custom_aggregate_name ); ?>
	<div class="katb_widget_rotate katb_widget_rotator_wrap<?php echo esc_attr( $format ); ?> image_meta_top" <?php echo $katb_widget_height_option_outside;// WPCS: XSS ok. ?>
				data-katb_speed="<?php echo esc_attr( $katb_widget_speed ); ?>"
				data-katb_transition="<?php echo esc_attr( $katb_widget_transition ); ?>">
		<?php
		global $katb_excerpt_required;
		// no schema switch.
		$use_schema = true;
		// $source is required to set up the excerpts if they are being used.
		$source = 'widget';
		for ( $i = 0; $i < $katb_widget_tnumber; $i++ ) {
			// get gravatar html.
			$gravatar_or_photo = katb_insert_gravatar( $katb_widget_tdata[ $i ]['tb_pic_url'], $gravatar_size, $use_gravatars, $use_round_images, $use_gravatar_substitute, $katb_widget_tdata[ $i ]['tb_email'] );
			$width_adj         = $gravatar_size + 10;
			// rotator div.
			if ( 0 === $i ) {
				$rotate_tag = 'show';
			} else {
				$rotate_tag = 'noshow';
			}
			?>
			<div class="katb_widget_rotator_box<?php echo esc_attr( $format ); ?> katb_widget_rotate_<?php echo $rotate_tag; // WPCS: XSS ok. ?>" itemscope itemtype="http://schema.org/Review" <?php echo esc_attr( $katb_widget_height_option ); ?>>
				<div class="katb_image_meta_top">
				<?php
				if ( '' === $gravatar_or_photo ) {
					?>
					<div class="katb_meta_top_wrap widget_meta" style="width:100%;">
					<?php
				} else {
					?>
					<div class="katb_gravatar_top">
						<?php echo $gravatar_or_photo; // WPCS: XSS ok. ?>
					</div>
					<div class="katb_meta_top_wrap widget_meta" style="width:calc(100% - <?php echo $width_adj; // WPCS: XSS ok. ?>px);">
					<?php
				}
					$divider = '';
					katb_get_author_html( $use_schema, $katb_widget_tdata[ $i ]['tb_name'], $divider );
					katb_get_date_html( $use_schema, $katb_options['katb_widget_show_date'], $katb_widget_tdata[ $i ]['tb_date'], $divider );
					katb_get_location_html( $katb_options['katb_widget_show_location'], $katb_widget_tdata[ $i ]['tb_location'], $divider );
					katb_get_custom1_html( $katb_options['katb_widget_show_custom1'], $katb_widget_tdata[ $i ]['tb_custom1'], $divider );
					katb_get_custom2_html( $katb_options['katb_widget_show_custom2'], $katb_widget_tdata[ $i ]['tb_custom2'], $divider );
					katb_get_website_html( $katb_options['katb_widget_show_website'], $katb_widget_tdata[ $i ]['tb_url'], $divider );
					katb_get_gdpr_link( $gdpr_remove_permalink, $katb_widget_tdata[ $i ]['tb_id'], $divider, 'remove_link_widget' );
					?>
					</div>
				</div>
				<div class="katb_title_rating_wrap">
				<?php
					katb_get_title_html( $use_title, $use_schema, $katb_widget_tdata[ $i ]['tb_group'], $katb_widget_tdata[ $i ]['tb_title'], $custom_title );
					katb_get_rating_html( $use_ratings, $use_schema, $katb_widget_tdata[ $i ]['tb_rating'] );
				?>
				</div>
				<div class="katb_testimonial_wrap">
				<?php
					$gravatarorphoto = '';
					katb_get_content_html( $use_schema, $format, $use_excerpts, $length, $gravatarorphoto, $katb_widget_tdata[ $i ]['tb_testimonial'], $katb_widget_tdata[ $i ]['tb_id'], $source );
				?>
				</div>
			</div>
			<?php
			// set up hidden popup if excerpt is used.
			if ( true === $use_excerpts && true === $katb_excerpt_required ) {
				katb_setup_popup( $i, $katb_widget_tdata, $gravatar_or_photo, 'widget' );
			}
		}
		?>
	</div>
</div>
