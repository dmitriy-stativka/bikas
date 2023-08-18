<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>


	<?php load_template(get_template_directory() . '/components/smallBanner.php', true); ?>


	<section class="category-section">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('category-section__inner'); ?>>
						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
						<div class="featured-post">
							<?php _e( 'Featured post', 'twentytwelve' ); ?>
						</div>
						<?php endif; ?>


					<div class="main-top category-section__top">
						<?php if ( ! post_password_required() && ! is_attachment() ) :
							the_post_thumbnail();
						endif; ?>

						<?php if ( is_single() ) : ?>
							<h1 class="main-top__title">
								<?php the_title(); ?>
							</h1>
						<?php else : ?>
							<h1 class="main-top__title">
								<?php the_title(); ?>
							</h1>
						<?php endif; ?>



						<?php if ( comments_open() ) : ?>
							<div class="comments-link">
								<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
							</div><!-- .comments-link -->
						<?php endif; // comments_open() ?>
					</div>


					<div class="catalog-aside">
						<?php dynamic_sidebar('sidebar-1'); ?>
					</div>


					<?php if ( is_search() ) : // Only display Excerpts for Search ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
					<?php else : ?>
					

						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>


						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>


					<?php endif; ?>

					<!-- <footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
					</footer>.entry-meta -->
				</article><!-- #post -->



				<?php /* comments_template( '', true ); */ ?>





			<?php endwhile; ?>
		</div>



	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>