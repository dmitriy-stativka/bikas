<?php
/**
 * @package MS-Reviews
 * @version 1.2
 */
/*
Plugin Name: MS-Reviews Отзывы
Description: Use the shortcode <b>[ms_reviews]</b> to display the feedback form in the right place on any page
Author: Mixail Sayapin
Version: 1.5
Author URI: https://ms-web.ru/
Text Domain: ms-reviews
*/

require_once 'classes/main.php';

\MS_WEB\MS_REVIEWS\Main::enqueAdminStyles();

register_activation_hook( __FILE__, array('MS_WEB\MS_REVIEWS\Main', 'onActivate') );
add_action('wp_enqueue_scripts', array('MS_WEB\MS_REVIEWS\Main', 'initJSCSS'));
add_action('wp_ajax_nopriv_msweb_MSReviews_ajax', array('MS_WEB\MS_REVIEWS\Main', 'ajaxCallback'));
add_action('wp_ajax_msweb_MSReviews_ajax', array('MS_WEB\MS_REVIEWS\Main', 'ajaxCallback'));
add_action('admin_menu', 'msweb_MSPlugins_menu');
add_action('admin_menu', array('MS_WEB\MS_REVIEWS\Main', 'adminMenuItem'));
add_shortcode('ms_reviews', array('MS_WEB\MS_REVIEWS\Main', 'getMSReviewsArea'));


if (!function_exists('msweb_MSPlugins_menu')) {
	/**
	 * "shared" code (repeat in all plugins) functions for all ms - plugins
	 */
	function msweb_MSPlugins_menu()
	{
		add_menu_page('MS-plugins', 'MS-plugins', 'manage_options', 'ms-plugins', 'msweb_MSPlugins_menu_page', 'none');
	}
}

// "shared" code (repeat in all plugins) functions for all ms - plugins
if (!function_exists('msweb_MSPlugins_menu_page')) {
	function msweb_MSPlugins_menu_page()
	{
		wp_enqueue_style('bootstrap', \MS_WEB\MS_REVIEWS\Main::getUrl() . '/bootstrap/css/bootstrap.css');
		$pluginsDirPath = plugin_dir_path(__DIR__);
		include_once 'templates/main.php';
	}
}


