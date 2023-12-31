<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<div class="featured-post">
					<?php _e( 'Featured post', 'twentytwelve' ); ?>
				</div>
			<?php endif; ?>

			<div class="container">
				<header class="entry-header">
					<?php if ( ! post_password_required() && ! is_attachment() ) : the_post_thumbnail(); endif; ?>

					<?php if ( is_single()  ) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php else : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php endif; ?>
					<!-- <?php if ( comments_open() ) : ?>
						<div class="comments-link">
							<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
						</div>
					<?php endif; ?> -->
				</header><!-- .entry-header -->


			</div>




		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>


	</div><!-- #post -->
