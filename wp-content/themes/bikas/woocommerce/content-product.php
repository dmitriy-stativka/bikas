<?php
$build_folder = get_template_directory_uri() . '/assets/build/';
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'product-card', $product ); ?>>

	<div class="pc">
		<div class="chooser choose-color">
            <?php if(get_field('color')):?>
				<div class="chooser__link active" style="background:<?php $colors = get_field('color'); echo $colors['value']; ?>"></div>
            <?php endif; ?>

			<?php 
                if( get_field('another', get_the_ID()) ):
                    $ids = get_field('another', get_the_ID());
                    $args = array(
                        'posts_per_page' => 11,
                        'post_type' => 'product',
                        'post__in' => $ids
                    );
                    $posts = get_posts( $args );
                    foreach( $posts as $pst ){
                        setup_postdata( $pst );
                        $cc = get_field('color',$pst->ID);
                        if(	$cc != $colors) {
                            if($cc) {
                                echo '<a class="chooser__link" title="'.get_the_title($pst->ID).'" href="'.get_permalink($pst->ID).'" style="background:'.$cc['value'].'"></a>';
                            }
                            
                        }
						
                    }
                endif;    
				//wp_reset_query();
            ?>

		</div>
	</div>

	<div class="product-card__nav">
		<span class="product-card__label">Нове</span>
		<button class="product-card__like">
			<svg width='18' height='18'>
				<use href='<?php echo $build_folder?>img/sprite/sprite.svg#favorite'></use>
			</svg>
		</button>
	</div>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' )?>
	
	<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"> 
		<?php the_post_thumbnail('full') ?>
	</a>

	<div class="product-card__info">

	
	
	
	<!-- <h2 class="woocommerce-loop-product__title">Модель КЗ- 232  (смарагдовий).(штучне хутро)</h2> <span class="price"><span class="woocommerce-Price-amount amount"><bdi>2350<span class="woocommerce-Price-currencySymbol">грн.</span></bdi></span></span> -->
	
	<?php

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );?>

	</div>
</div>
