<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>


<?php
if( get_field('color') ):
		$colors = get_field('color');
		 ?>
			<div class="the-form">
				<span>Колір:</span>
				<div class="chooser choose-color">
					<div class="acti" title="<?php echo $colors['label'] ?>" style="background:<?php echo $colors['value'] ?>"></div>
					<?php 
							
							if( get_field('another') ): 
							$ids = get_field('another');
							// задаем нужные нам критерии выборки данных из БД
							$args = array(
								'posts_per_page' => -1,
								'post_type' => 'product',
								'post__in' => $ids
							);

							$query = new WP_Query( $args );

							// Цикл
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();
									$c = get_field('color');
									if(	get_field('color') != $colors) {
										echo '<a title="'.$c['label'].'" href="'.get_permalink().'" style="background:'.$c['value'].'"></a>';
									}
								}
							} 
							// Возвращаем оригинальные данные поста. Сбрасываем $post.
							wp_reset_postdata();
						endif; 
					?>
				</div>
			</div>

	<?php endif;  ?>


	<?php if( get_field('meh') ): ?>
		<div class="the-form meh">
			<span>Хутро:</span>
			<div class="chooser choose-next">
				<div class="acti"><?php echo $memory = get_field('meh') ?></div>
				<?php 
					if( get_field('another_meh') ): 
						$ids = get_field('another_meh');
						// задаем нужные нам критерии выборки данных из БД
						$args = array(
							'posts_per_page' => -1,
							'post_type' => 'product',
							'post__in' => $ids
						);

						$query = new WP_Query( $args );
						// Цикл
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								if(	get_field('meh') != $memory) {
									echo '<a title="'.get_the_title().'" href="'.get_permalink().'">'.get_field('meh').'</a>';
								}
							}
						} 
						// Возвращаем оригинальные данные поста. Сбрасываем $post.
						wp_reset_postdata();
					endif; 
				?>
			</div>
		</div>
	<?php endif;  ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>





