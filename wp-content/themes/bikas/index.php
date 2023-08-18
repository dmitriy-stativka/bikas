<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link       https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    WordPress
 * @subpackage Twenty_Twelve
 * @since      Twenty Twelve 1.0
 */

get_header(); ?>
    <div id="primary" class="site-content">
        <div id="content" role="main">
			<?php
			echo do_shortcode( '[metaslider id=204]' ); ?>
        </div>
    </div>
<?php
get_sidebar(); ?>
    <div class="home-category">
        <div class="home-category-item">
			<?php
			$termId = 79;

			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id = get_term_meta( $termId, 'thumbnail_id', true );
				//$image = wp_get_attachment_url( $thumbnail_id );
				//echo '<img src="'.$image.'" alt="'.$term->name.'" width="280" height="280" />';
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 80;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 81;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 82;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 83;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 84;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId = 85;
			if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
				echo '<a href="' . get_term_link( $termId, 'product_cat' )
				     . '">';
				$thumbnail_id     = get_term_meta( $termId, 'thumbnail_id',
					true );
				$image_attributes = wp_get_attachment_image_src( $thumbnail_id,
					'medium' );
				if ( $image_attributes ) { ?>
                    <img src="<?php
					echo $image_attributes[0]; ?>" width="<?php
					echo $image_attributes[1]; ?>" height="<?php
					echo $image_attributes[2]; ?>"/>
					<?php
				}
				echo '<h2>' . $term->name . '</h2></a>';
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId       = 87;
			$thumbnail_id = get_term_meta( $termId, 'thumbnail_id', true );
			if ( $thumbnail_id ) {
				if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
					echo '<a href="' . get_term_link( $termId, 'product_cat' )
					     . '">';
					$thumbnail_id = get_term_meta( $termId, 'thumbnail_id',
						true );
					$image_attributes
					              = wp_get_attachment_image_src( $thumbnail_id,
						'medium' );
					if ( $image_attributes ) { ?>
                        <img src="<?php
						echo $image_attributes[0]; ?>" width="<?php
						echo $image_attributes[1]; ?>" height="<?php
						echo $image_attributes[2]; ?>"/>
						<?php
					}
					echo '<h2>' . $term->name . '</h2></a>';
				}
			}
			?>
        </div>
        <div class="home-category-item">
			<?php
			$termId       = 88;
			$thumbnail_id = get_term_meta( $termId, 'thumbnail_id', true );
			if ( $thumbnail_id ) {
				if ( $term = get_term_by( 'id', $termId, 'product_cat' ) ) {
					echo '<a href="' . get_term_link( $termId, 'product_cat' )
					     . '">';
					$thumbnail_id = get_term_meta( $termId, 'thumbnail_id',
						true );
					$image_attributes
					              = wp_get_attachment_image_src( $thumbnail_id,
						'medium' );
					if ( $image_attributes ) { ?>
                        <img src="<?php
						echo $image_attributes[0]; ?>" width="<?php
						echo $image_attributes[1]; ?>" height="<?php
						echo $image_attributes[2]; ?>"/>
						<?php
					}
					echo '<h2>' . $term->name . '</h2></a>';
				}
			}
			?>
        </div>
        <h2 class="home-h2">Наша продукція</h2>
		<?php
		echo do_shortcode( '[recent_products per_page="12" columns="4"]' ); ?>
        <center><a href="https://bikas.com.ua/shop/" class="home-button">Усі
                товари</a></center>
        <div class="home-widget">
			<?php
			if ( is_active_sidebar( 'index-page' ) ) : ?>
				<?php
				dynamic_sidebar( 'index-page' ); ?>
			<?php
			endif; ?>

        </div>
    </div>
<?php
get_footer(); ?>