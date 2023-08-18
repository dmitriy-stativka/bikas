<?php
/**
 * @package Exchange Rates Today
 * @version 1.7
 */
/*
Plugin Name: Exchange Rates Today
Plugin URI: http://silver.od.ua
Description: A simple plugin for WooCommerce that allows you to change the price according to the exchange rate. For example, you set the price on the website in dollars and in-store price is displayed in local currency, you simply are asking today's exchange rate, but the plugin automatically changes all prices.
Author: Artyom Lagondyuk
Version: 1.7
Author URI: http://silver.od.ua
*/



add_action ('admin_menu', 'dynamic_price_button');
//Simple product
add_filter('woocommerce_product_get_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_get_regular_price', 'custom_price', 99, 2 );
add_filter( 'woocommerce_price_filter_widget_min_amount', 'custom_price', 99, 2);
add_filter( 'woocommerce_price_filter_widget_max_amount', 'custom_price', 99, 2);
// Variable
add_filter('woocommerce_product_variation_get_regular_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_variation_get_price', 'custom_price', 99, 2 );
// Variations
add_filter('woocommerce_variation_prices_price', 'custom_price', 99, 3 );
add_filter('woocommerce_variation_prices_regular_price', 'custom_price', 99, 3 );
add_filter( 'woocommerce_variation_prices_sale_price',    'custom_price', 99, 3  );
// Handling price caching (see explanations at the end)
add_filter( 'woocommerce_get_variation_prices_hash', 'add_price_multiplier_to_variation_prices_hash', 99, 1 );

add_action( 'admin_init', 'register_mysettings' );

function register_mysettings () {
    register_setting( 'baw-settings-group', 'kurs' );
    register_setting( 'baw-settings-group', 'valuta' );
}

function custom_price ($price) {
    $int = floatval($price);
    $kurs=get_option('kurs');
    if ($kurs!='') {
        return $int*$kurs;
    } else  return  $int;
}

function add_price_multiplier_to_variation_prices_hash($hash){
    $hash[] = get_option('kurs');
    return $hash;
}

function dynamic_price_button () {
    add_submenu_page ('woocommerce', 'Курс сегодня', 'Курс сегодня', 'manage_options', 'dynamic_price', 'setting_page');
}

function setting_page () {
?>
<div class="wrap">
<h2>Курс на сегодня</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Курс</th>
        <td><input type="text" name="kurs" value="<?php echo get_option('kurs'); ?>" /></td>
        </tr>               
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php }

add_filter( 'woocommerce_product_query_meta_query', 'filter_function_name_3276', 10, 2 );
function filter_function_name_3276( $meta_query ){
    if ( isset( $_GET['max_price'] ) || isset( $_GET['min_price'] ) ) { // WPCS: input var ok, CSRF ok.
            $kurs=get_option('kurs');
            if (isset($_GET['min_price']) && $_GET['min_price']>0){
                $meta_query['price_filter']['value'][0] =  $meta_query['price_filter']['value'][0]/$kurs;
            };
            if (isset($_GET['max_price'])){
                $meta_query['price_filter']['value'][1] =  $meta_query['price_filter']['value'][1]/$kurs;
            };
            return $meta_query;
    }
    return $meta_query;
}